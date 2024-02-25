<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary\DTO;

use JsonSerializable;

class UserDTO implements JsonSerializable {
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $avatar,
    ) {}

    public static function create(int $id, string $firstName, string $email, string $lastName, string $avatar): UserDTO {
        return new self($id, $email, $firstName, $lastName, $avatar);
    }

    /**
     * Implement contract method to be used when encoding json/creating json object
     *
     * @return string
     */
    public function jsonSerialize(): mixed
    {
        return [
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'avatar' => $this->avatar,
            ]
        ];
    }
}

?>