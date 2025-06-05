<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATContactPoint.
 *
 * Represents the complex entity DCATContactPoint. It consists of six properties: 'fullName',
 * 'address', 'title', 'email', 'webpage' and 'phone'. The property 'fullName' is required as is one
 * of [ email, webpage or phone ].
 */
class DCATContactPoint extends DCATComplexEntity
{
    protected ?DCATLiteral $fullName;

    protected ?DCATLiteral $address;

    protected ?DCATLiteral $title;

    protected ?DCATLiteral $email;

    protected ?DCATURI $webpage;

    protected ?DCATLiteral $phone;

    /**
     * DCATContactPoint constructor.
     */
    public function __construct()
    {
        parent::__construct(
            ['fullName', 'address', 'title', 'email', 'webpage', 'phone'],
            ['fullName']
        );
    }

    /**
     * Determines and returns whether the DCATContactPoint is valid.
     *
     * A DCATContactPoint is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     * - At least one of the following properties is present and valid: `$this->email`,
     * `$this->webpage` or `$this->phone`
     *
     * @see DCATComplexEntity::validate()
     *
     * @return DCATValidationResult The validation result of this DCATContactPoint
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (is_null($this->email) && is_null($this->webpage) && is_null($this->phone)) {
            $result->addMessage('email, webpage or phone is required');
        }

        return $result;
    }

    /**
     * Getter for the fullName property, may return null.
     *
     * @return null|DCATLiteral The fullName property
     */
    public function getFullName(): ?DCATLiteral
    {
        return $this->fullName;
    }

    /**
     * Getter for the address property, may return null.
     *
     * @return null|DCATLiteral The address property
     */
    public function getAddress(): ?DCATLiteral
    {
        return $this->address;
    }

    /**
     * Getter for the title property, may return null.
     *
     * @return null|DCATLiteral The title property
     */
    public function getTitle(): ?DCATLiteral
    {
        return $this->title;
    }

    /**
     * Getter for the email property, may return null.
     *
     * @return null|DCATLiteral The email property
     */
    public function getEmail(): ?DCATLiteral
    {
        return $this->email;
    }

    /**
     * Getter for the webpage property, may return null.
     *
     * @return null|DCATURI The webpage property
     */
    public function getWebpage(): ?DCATURI
    {
        return $this->webpage;
    }

    /**
     * Getter for the phone property, may return null.
     *
     * @return null|DCATLiteral The phone property
     */
    public function getPhone(): ?DCATLiteral
    {
        return $this->phone;
    }

    /**
     * Setter for the fullName property.
     *
     * @param DCATLiteral $fullName The value to set
     */
    public function setFullName(DCATLiteral $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * Setter for the address property.
     *
     * @param DCATLiteral $address The value to set
     */
    public function setAddress(DCATLiteral $address): void
    {
        $this->address = $address;
    }

    /**
     * Setter for the title property.
     *
     * @param DCATLiteral $title The value to set
     */
    public function setTitle(DCATLiteral $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for the email property.
     *
     * @param DCATLiteral $email The value to set
     */
    public function setEmail(DCATLiteral $email): void
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
     * @param DCATLiteral $phone The value to set
     */
    public function setPhone(DCATLiteral $phone): void
    {
        $this->phone = $phone;
    }
}
