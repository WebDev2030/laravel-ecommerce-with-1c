<?php

namespace App\EAV\Traites;

use Closure;
use App\EAV\Models\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait Attributable
{
    /**
     * Атрибуты сущностей
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected static $entityAttributes;

    /**
     * The entity attribute relations.
     *
     * @var array
     */
    protected $entityAttributeRelations = [];

    /**
     * Determine if the entity attribute relations have been booted.
     *
     * @var bool
     */
    protected bool $entityAttributeRelationsBooted = false;


    /**
     * Check if the model needs to be booted and if so, do it.
     *
     * @return void
     */
    protected function bootIfNotBooted(): void
    {
        parent::bootIfNotBooted();

        if (! $this->entityAttributeRelationsBooted) {
            $attributes = $this->getEntityAttributes();

            // We will manually add a relationship for every attribute registered
            // of this entity. Once we know the relation method we have to use,
            // we will just add it to the entityAttributeRelations property.
            foreach ($attributes as $attribute) {
                // $method = (bool) ($attribute->getAttributes()['is_collection'] ?? null) ? 'hasMany' : 'hasOne';
                 $method = 'hasOne';

                // This will return a closure fully binded to the current entity instance,
                // which will help us to simulate any relation as if it was made in the
                // original entity class definition using a function statement.
                $relation = Closure::bind(function () use ($attribute, $method) {
                    dump($attribute->getAttribute('type'));
                    $relation = $this->{$method}(Attribute::getTypeModel($attribute->getAttribute('type')), 'model_id', $this->getKeyName());

                    // Since an attribute could be attached to multiple entities, then values could have
                    // same entity ID, but for different entity types, so we need to add type where
                    // clause to fetch only values related to the given entity ID + entity type.
                    $relation->where('model', $this->getMorphClass());

                    // We add a where clause in order to fetch only the elements that are
                    // related to the given attribute. If no condition is set, it will
                    // fetch all the value rows related to the current entity.
                    return $relation->where($attribute->getForeignKey(), $attribute->getKey());
                }, $this, get_class($this));

                dump($relation);

                $this->setEntityAttributeRelation((string) ($attribute->getAttributes()['slug'] ?? null), $relation);
            }

            $this->entityAttributeRelationsBooted = true;
        }
    }

    /**
     * Set the entity attribute relation.
     *
     * @param string $relation
     * @param mixed  $value
     *
     * @return $this
     */
    public function setEntityAttributeRelation(string $relation, $value)
    {
        $this->entityAttributeRelations[$relation] = $value;

        return $this;
    }

    /**
     * Вытаскиваем атрибуты сущности
     *
     * @return Collection
     */
    public function getEntityAttributes(): Collection
    {
        $morphClass = $this->getMorphClass();
        static::$entityAttributes = static::$entityAttributes ?? collect();

        if (!static::$entityAttributes->has($morphClass)) {
            static::$entityAttributes->put($morphClass, (new Attribute())->where('model', $morphClass)->orderBy('sort', 'ASC')->get()->keyBy('slug'));
        }

        return static::$entityAttributes->get($morphClass) ?? new Collection();
    }

    /**
     * Вытаскиваем значение атрибута сущности
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function getEntityAttributeValue(string $key)
    {
//        $value = $this->getEntityAttributeRelation($key);
//
//        // In case we are accessing to a multivalued attribute, we will return
//        // a collection with pairs of id and value content. Otherwise we'll
//        // just return the single model value content as a plain result.
//        if ($this->getEntityAttributes()->get($key)->is_collection) {
//            return $value->pluck('content');
//        }
//
//        return ! is_null($value) ? $value->getAttribute('content') : null;
    }

    /**
     * Set the given relationship on the model.
     *
     * @param string $relation
     * @param mixed  $value
     *
     * @return array
     */
    public function relationsToArray():array
    {
        $eavAttributes = [];
        $attributes = parent::relationsToArray();
        $relations = array_keys($this->getEntityAttributeRelations());

        foreach ($relations as $relation) {
            if (array_key_exists($relation, $attributes)) {
                $eavAttributes[$relation] = $this->getAttribute($relation) instanceof BaseCollection
                    ? $this->getAttribute($relation)->toArray() : $this->getAttribute($relation);

                // By unsetting the relation from the attributes array we will make
                // sure we do not provide a duplicity when adding the namespace.
                // Otherwise it would keep the relation as a key in the root.
                unset($attributes[$relation]);
            }
        }

        if (is_null($namespace = $this->getEntityAttributesNamespace())) {
            $attributes = array_merge($attributes, $eavAttributes);
        } else {
            Arr::set($attributes, $namespace, $eavAttributes);
        }

        return $attributes;
    }

    /**
     * Get the entity attribute relations.
     *
     * @return array
     */
    public function getEntityAttributeRelations(): array
    {
        return $this->entityAttributeRelations;
    }

    /**
     * Get the entity attributes namespace if exists.
     *
     * @return string|null
     */
    public function getEntityAttributesNamespace(): ?string
    {
        return property_exists($this, 'entityAttributesNamespace') ? $this->entityAttributesNamespace : null;
    }

}
