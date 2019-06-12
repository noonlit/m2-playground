<?php

namespace BabaYaga\Customer\Model\ResourceModel;

use BabaYaga\Customer\Api\Data\CustomerNoteInterface;
use BabaYaga\Customer\Model\ResourceModel\Note as NoteResource;
use BabaYaga\Customer\Model\NoteFactory;
use BabaYaga\Customer\Api\Data\CustomerNoteRepositoryInterface;

/**
 * Class CustomerNoteRepository
 *
 * @package BabaYaga\Customer\Model\ResourceModel
 */
class CustomerNoteRepository implements CustomerNoteRepositoryInterface
{
    /**
     * @var Note
     */
    private $resource;

    /**
     * @var NoteFactory
     */
    private $factory;

    /**
     * CustomerNoteRepository constructor.
     *
     * @param \BabaYaga\Customer\Model\ResourceModel\Note $noteResourceModel
     * @param NoteFactory                                 $noteFactory
     */
    public function __construct(NoteResource $noteResourceModel, NoteFactory $noteFactory)
    {
        $this->resource = $noteResourceModel;
        $this->factory  = $noteFactory;
    }

    /**
     * @param CustomerNoteInterface $customerNote
     *
     * @return Note|mixed
     * @throws \Exception
     */
    public function delete(CustomerNoteInterface $customerNote)
    {
        return $this->resource->delete($customerNote);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    /**
     * @param $customerNoteId
     *
     * @return CustomerNoteInterface
     */
    public function getById(int $customerNoteId): CustomerNoteInterface
    {
        $note = $this->factory->create();
        $this->resource->load($note, $customerNoteId);
        return $note;
    }

    /**
     * @param int $customerId
     *
     * @return CustomerNoteInterface
     */
    public function getByCustomerId(int $customerId) : CustomerNoteInterface
    {
        $note = $this->factory->create();
        $this->resource->load($note, $customerId, 'customer_id');

        return $note;
    }

    /**
     * @param int $customerNoteId
     *
     * @return Note|mixed
     * @throws \Exception
     */
    public function deleteById($customerNoteId)
    {
        $note = $this->factory->create();
        $this->resource->load($note, $customerNoteId);
        return $this->resource->delete($note);
    }

    /**
     * @param CustomerNoteInterface $customerNote
     *
     * @return Note|mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(CustomerNoteInterface $customerNote)
    {
        return $this->resource->save($customerNote);
    }
}
