<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskUserTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'taskUserType', targetEntity: TaskUser::class)]
    private $taskUsers;

    public function __construct()
    {
        $this->taskUsers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string)$this->getName();
    }

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

    /**
     * @return Collection<int, TaskUser>
     */
    public function getTaskUsers(): Collection
    {
        return $this->taskUsers;
    }

    public function addTaskUser(TaskUser $taskUser): self
    {
        if (!$this->taskUsers->contains($taskUser)) {
            $this->taskUsers[] = $taskUser;
            $taskUser->setTaskUserType($this);
        }

        return $this;
    }

    public function removeTaskUser(TaskUser $taskUser): self
    {
        if ($this->taskUsers->removeElement($taskUser)) {
            // set the owning side to null (unless already changed)
            if ($taskUser->getTaskUserType() === $this) {
                $taskUser->setTaskUserType(null);
            }
        }

        return $this;
    }
}
