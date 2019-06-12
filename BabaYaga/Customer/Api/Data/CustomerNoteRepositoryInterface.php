<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace BabaYaga\Customer\Api\Data;

/**
 * Interface CustomerNoteRepositoryInterface
 *
 * @package BabaYaga\Customer\Api\Data
 */
interface CustomerNoteRepositoryInterface
{

    /**
     * @param CustomerNoteInterface $customerNote
     *
     * @return mixed
     */
    public function save(CustomerNoteInterface $customerNote);

    /**
     * @param int $customerNoteId
     *
     * @return CustomerNoteInterface
     */
    public function getById(int $customerNoteId) : CustomerNoteInterface;

    /**
     * @param int $customerId
     *
     * @return CustomerNoteInterface
     */
    public function getByCustomerId(int $customerId) : CustomerNoteInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param CustomerNoteInterface $customerNote
     *
     * @return mixed
     */
    public function delete(CustomerNoteInterface $customerNote);

    /**
     * @param int $customerNoteId
     *
     * @return mixed
     */
    public function deleteById(int $customerNoteId);
}
