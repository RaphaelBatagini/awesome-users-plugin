<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

abstract class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Items list
     * @var array
     */
    protected array $items;

    /**
     * Sets up object items
     *
     * @return self
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Check if given offset exists
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        if (is_integer($offset) || is_string($offset)) {
            return array_key_exists($offset, $this->items);
        }

        return false;
    }

    /**
     * Retrieve the item of a given offset
     *
     * @return \mixed
     */
    public function offsetGet($offset): \mixed
    {
        return $this->items[$offset];
    }

    /**
     * Assign a value to an offset
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
            return;
        }

        $this->items[$offset] = $value;
    }

    /**
     * Remove the given offset from the collection
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * Get collection items quantity
     *
     * @return void
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Return an iterator
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
