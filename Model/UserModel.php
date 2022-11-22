<?php

namespace App\Model;

class UserModel
{
    /**
     * @param int $id
     * @param int $userId
     * @param string $title
     * @param string $body
     */
    public function __construct(
        private ?int $id = null,
        private ?string $firstName = null,
        private ?string $secondName = null,
        private ?string $email = null,
        private ?string $phone = null,
        private ?AddressModel $address = null,
        private ?\DateTimeImmutable $registered_at = null
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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return AddressModel|null
     */
    public function getAddress(): ?AddressModel
    {
        return $this->address;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registered_at;
    }

}
