<?php

namespace App\Model;

class AddressModel
{
    /**
     * @param int $id
     * @param int $userId
     * @param string $title
     * @param string $body
     */
    public function __construct(
        private ?int $id = null,
        private ?string $city = null,
        private ?string $street = null,
        private ?string $building = null,
        private ?string $zipcode = null,
    ){
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getBuilding(): ?string
    {
        return $this->building;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

}
