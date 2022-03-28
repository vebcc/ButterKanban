<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskUserTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskUserTypeRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'taskUserType:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'taskUserType:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
    ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'taskUserType:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'taskUserType:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'taskUserType:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class TaskUserType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['taskUserType:list', 'taskUserType:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['taskUserType:list', 'taskUserType:item'])]
    private $name;

    #[ORM\ManyToOne(targetEntity: TaskUser::class, inversedBy: 'userType')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['taskUserType:list', 'taskUserType:item'])]
    private $taskUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTaskUser(): ?TaskUser
    {
        return $this->taskUser;
    }

    public function setTaskUser(?TaskUser $taskUser): self
    {
        $this->taskUser = $taskUser;

        return $this;
    }
}
