<?php

namespace App\Entity;

use App\Entity\Traits\EntityIdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
  
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telegramId;

    /**
     * Date/Time of the last activity.
     *
     * @var \Datetime
     * @ORM\Column(name="last_activity_at", type="datetime")
     */
    protected $lastActivityAt;



    public function __construct()
    {
              $this->lastActivityAt = new \DateTime('now');
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
    public function getUsername(): string
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Todo[]
     */
    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function addTodo(Todo $todo): self
    {
        if (!$this->todos->contains($todo)) {
            $this->todos[] = $todo;
            $todo->setAssignedTo($this);
        }

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->contains($todo)) {
            $this->todos->removeElement($todo);
            // set the owning side to null (unless already changed)
            if ($todo->getAssignedTo() === $this) {
                $todo->setAssignedTo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return trim($this->firstName).' '.trim($this->lastName);
    }

    /**
     * @param \Datetime $lastActivityAt
     */
    public function setLastActivityAt($lastActivityAt)
    {
        $this->lastActivityAt = $lastActivityAt;
    }

    /**
     * @return \Datetime
     */
    public function getLastActivityAt()
    {
        return $this->lastActivityAt;
    }

    /**
     * @return bool Whether the user is active or not
     */
    public function isActiveNow(): bool
    {
        // Delay during wich the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return $this->getLastActivityAt() > $delay;
    }

    /**
     * @return Collection|Timesheet[]
     */
    public function getTimesheets(): Collection
    {
        return $this->timesheets;
    }

    public function addTimesheet(Timesheet $timesheet): self
    {
        if (!$this->timesheets->contains($timesheet)) {
            $this->timesheets[] = $timesheet;
            $timesheet->setAssignedTo($this);
        }

        return $this;
    }

    public function removeTimesheet(Timesheet $timesheet): self
    {
        if ($this->timesheets->contains($timesheet)) {
            $this->timesheets->removeElement($timesheet);
            // set the owning side to null (unless already changed)
            if ($timesheet->getAssignedTo() === $this) {
                $timesheet->setAssignedTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CalendarEvent[]
     */
    public function getCalendarEvents(): Collection
    {
        return $this->calendarEvents;
    }

    public function addCalendarEvent(CalendarEvent $calendarEvent): self
    {
        if (!$this->calendarEvents->contains($calendarEvent)) {
            $this->calendarEvents[] = $calendarEvent;
            $calendarEvent->setOwner($this);
        }

        return $this;
    }

    public function removeCalendarEvent(CalendarEvent $calendarEvent): self
    {
        if ($this->calendarEvents->removeElement($calendarEvent)) {
            // set the owning side to null (unless already changed)
            if ($calendarEvent->getOwner() === $this) {
                $calendarEvent->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelegramId()
    {
        return $this->telegramId;
    }

    /**
     * @param mixed $telegramId
     * @return User
     */
    public function setTelegramId($telegramId)
    {
        $this->telegramId = $telegramId;

        return $this;
    }


}
