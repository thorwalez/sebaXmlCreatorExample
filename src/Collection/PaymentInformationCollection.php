<?php


namespace App\Collection;

use App\Exceptions\Error\NotFoundKeyException;
use App\Filter\FilterInterface;
use App\Model\PaymentInformation;

/**
 * Class PaymentInformationCollection
 * @package App\Collection
 */
class PaymentInformationCollection implements DataCollectionInterface
{
    /** @var array $items */
    private $items;

    /**
     * PaymentInformationCollection constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param PaymentInformation $obj
     * @param string         $key
     */
    public function addItem($obj, $key = null) : void
    {
        if (\is_null($key)) {
            $this->items[] = $obj;
        } else {
            $this->items[$key] = $obj;
        }

    }

    /**
     * @param string $key
     * @throws NotFoundKeyException
     */
    public function deleteItem(string $key) : void
    {
        if ($this->hasKey($key)){
            unset($this->items[$key]);
        }else{
            throw new NotFoundKeyException("Key: $key could not be found.");
        }
    }

    /**
     * @param string $key
     * @return PaymentInformation
     * @throws NotFoundKeyException
     */
    public function getItem(string $key) : PaymentInformation
    {
        if ($this->hasKey($key)){
            return $this->items[$key];
        }
        throw new NotFoundKeyException("Key: $key could not be found.");
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return \count($this->items);
    }

    /**
     * @param FilterInterface $filter
     * @return DataCollectionInterface
     */
    public function filter(FilterInterface $filter) : DataCollectionInterface
    {
        return new PaymentInformationCollection($filter->filter($this->toArray()));
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key) : bool
    {
        return isset($this->items[$key]);
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return \current((array)$this);
    }

}