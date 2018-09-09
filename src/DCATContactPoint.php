<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATContactPoint
 *
 * Represents the complex entity DCATContactPoint. It consists of six properties: 'fullName',
 * 'address', 'title', 'email', 'webpage' and 'phone'. The property 'fullName' is required as is one
 * of [ email, webpage or phone ].
 *
 * @package DCAT_AP_DONL
 */
class DCATContactPoint extends DCATComplexEntity {

    /** @var string[] */
    protected static $PROPERTIES = [
        'fullName', 'address', 'title', 'email', 'webpage', 'phone'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'fullName'
    ];

    /** @var DCATProperty */
    protected $fullName;

    /** @var DCATProperty */
    protected $address;

    /** @var DCATProperty */
    protected $title;

    /** @var DCATProperty */
    protected $email;

    /** @var DCATURI */
    protected $webpage;

    /** @var DCATProperty */
    protected $phone;

    /**
     * DCATContactPoint constructor.
     */
    public function __construct()
    {
        parent::__construct('ContactPoint', self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Determines and returns whether or not the DCATContactPoint is valid.
     *
     * A DCATContactPoint is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     * - At least one of the following properties is present and valid: `$this->email`,
     * `$this->webpage` or `$this->phone`
     *
     * @see DCATComplexEntity::validate()
     * @return DCATValidationResult The validation result of this DCATContactPoint
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if ($this->email == null && $this->webpage == null && $this->phone == null) {
            $result->addMessage(
                sprintf('%s: email, webpage or phone is required', $this->getName())
            );
        }

        return $result;
    }

    /**
     * Getter for the fullName property, may return null.
     *
     * @return DCATProperty|null The fullName property
     */
    public function getFullName(): ?DCATProperty
    {
        return $this->fullName;
    }

    /**
     * Getter for the address property, may return null.
     *
     * @return DCATProperty|null The address property
     */
    public function getAddress(): ?DCATProperty
    {
        return $this->address;
    }

    /**
     * Getter for the title property, may return null.
     *
     * @return DCATProperty|null The title property
     */
    public function getTitle(): ?DCATProperty
    {
        return $this->title;
    }

    /**
     * Getter for the email property, may return null.
     *
     * @return DCATProperty|null The email property
     */
    public function getEmail(): ?DCATProperty
    {
        return $this->email;
    }

    /**
     * Getter for the webpage property, may return null.
     *
     * @return DCATURI|null The webpage property
     */
    public function getWebpage(): ?DCATURI
    {
        return $this->webpage;
    }

    /**
     * Getter for the phone property, may return null.
     *
     * @return DCATProperty|null The phone property
     */
    public function getPhone(): ?DCATProperty
    {
        return $this->phone;
    }

    /**
     * Setter for the fullName property.
     *
     * @param DCATProperty $fullName The value to set
     */
    public function setFullName(DCATProperty $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * Setter for the address property.
     *
     * @param DCATProperty $address The value to set
     */
    public function setAddress(DCATProperty $address): void
    {
        $this->address = $address;
    }

    /**
     * Setter for the title property.
     *
     * @param DCATProperty $title The value to set
     */
    public function setTitle(DCATProperty $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for the email property.
     *
     * @param DCATProperty $email The value to set
     */
    public function setEmail(DCATProperty $email): void
    {
        $this->email = $email;
    }

    /**
     * Setter for the webpage property.
     *
     * @param DCATURI $webpage The value to set
     */
    public function setWebpage(DCATURI $webpage): void
    {
        $this->webpage = $webpage;
    }

    /**
     * Setter for the phone property.
     *
     * @param DCATProperty $phone The value to set
     */
    public function setPhone(DCATProperty $phone): void
    {
        $this->phone = $phone;
    }

}
