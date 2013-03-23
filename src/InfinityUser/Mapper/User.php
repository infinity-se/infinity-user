<?php

namespace InfinityUser\Mapper;

use InfinityUser\Entity\UserEmail;
use InfinityUser\Entity\UserProfile;
use ZfcUserDoctrineORM\Mapper\User as ZfcUserMapper;

class User extends ZfcUserMapper
{

    public function findByEmail($email)
    {
        $userEmailRepository = $this->em->getRepository('InfinityUser\Entity\UserEmail');
        $userEmail           = $userEmailRepository->findOneBy(array('email' => $email));
        if ($userEmail instanceof UserEmail) {
            $userRepository = $this->em->getRepository('InfinityUser\Entity\User');
            return $userRepository->findOneBy(array('primaryEmail' => $userEmail));
        }
    }

    public function findByUsername($username)
    {
        $repository  = $this->em->getRepository('InfinityUser\Entity\UserProfile');
        $userProfile = $repository->findOneBy(array('name' => $username));
        if ($userProfile instanceof UserProfile) {
            return $userProfile->getUser();
        }
    }

    public function persistOnly($entity)
    {
        $this->em->persist($entity);

        return $entity;
    }

}