<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'user:list'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'post' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'user:list'],
            "access_control_message" => "You do not have the permission to post"
        ]
    ],
    itemOperations: [
        'get' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'user:item'],
            "access_control_message" => "You do not have the permission to get"
        ],
        'patch' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'user:item'],
            "access_control_message" => "You do not have the permission to patch"
        ],
        'delete' => [
            'access_control' =>"is_granted('ROLE_ADMIN')" ,
            'normalization_context' => ['groups' => 'user:item'],
            "access_control_message" => "You do not have the permission to delete"
        ]
    ],
    paginationEnabled: false,
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['user:list', 'user:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['user:list', 'user:item'])]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['user:list', 'user:item'])]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['user:list', 'user:item'])]
    private $password;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['user:list', 'user:item'])]
    private $name;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['user:list', 'user:item'])]
    private $creationDate;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TaskUser::class, orphanRemoval: true)]
    #[Groups(['user:list', 'user:item'])]
    private $taskUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TaskComment::class)]
    #[Groups(['user:list', 'user:item'])]
    private $taskComments;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['user:list', 'user:item'])]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Log::class, orphanRemoval: true)]
    private $logs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ApiToken::class, orphanRemoval: true)]
    private $apiTokens;

    public function __construct()
    {
        $this->taskUsers = new ArrayCollection();
        $this->taskComments = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->logs = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string)$this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

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
            $taskUser->setUser($this);
        }

        return $this;
    }

    public function removeTaskUser(TaskUser $taskUser): self
    {
        if ($this->taskUsers->removeElement($taskUser)) {
            // set the owning side to null (unless already changed)
            if ($taskUser->getUser() === $this) {
                $taskUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TaskComment>
     */
    public function getTaskComments(): Collection
    {
        return $this->taskComments;
    }

    public function addTaskComment(TaskComment $taskComment): self
    {
        if (!$this->taskComments->contains($taskComment)) {
            $this->taskComments[] = $taskComment;
            $taskComment->setUser($this);
        }

        return $this;
    }

    public function removeTaskComment(TaskComment $taskComment): self
    {
        if ($this->taskComments->removeElement($taskComment)) {
            // set the owning side to null (unless already changed)
            if ($taskComment->getUser() === $this) {
                $taskComment->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs[] = $log;
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApiToken>
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function getLastApiToken(): ApiToken
    {
        return $this->apiTokens[0];
    }

    public function addApiToken(ApiToken $apiToken): self
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
            $apiToken->setUser($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): self
    {
        if ($this->apiTokens->removeElement($apiToken)) {
            // set the owning side to null (unless already changed)
            if ($apiToken->getUser() === $this) {
                $apiToken->setUser(null);
            }
        }

        return $this;
    }
}
