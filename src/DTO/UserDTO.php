<?php

namespace Sarahheanan\PlentificCodingChallengeLibrary\DTO;

class UserDTO {
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
}

?>