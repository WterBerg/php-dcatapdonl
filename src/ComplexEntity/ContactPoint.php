<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATValidationResult;


/**
 * Class ContactPoint
 *
 * Represents the complex entity ContactPoint. It consists of six properties: 'fullName', 'address',
 * 'title', 'email', 'webpage' and 'phone'. The property 'fullName' is required as is one of
 * [ email, webpage or phone ].
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
class ContactPoint extends DCATComplexEntity {

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
     * ContactPoint constructor.
     *
     * @param DCATProperty|null $name
     * @param DCATProperty|null $address
     * @param DCATProperty|null $title
     * @param DCATProperty|null $email
     * @param DCATURI|null $webpage
     * @param DCATProperty|null $phone
     */
    public function __construct(DCATProperty $name = null, DCATProperty $address = null,
                                DCATProperty $title = null, DCATProperty $email = null,
                                DCATURI $webpage = null, DCATProperty $phone = null)
    {
        parent::__construct('ContactPoint');

        $this->fullName = $name;
        $this->address = $address;
        $this->title = $title;
        $this->email = $email;
        $this->webpage = $webpage;
        $this->phone = $phone;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        $data = [];

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property && $this->$property->validate()->validated()) {
                $data[$this->$property->getName()] = $this->$property->getData();
            }
        }

        return $data;
    }

    /**
     * Determines and returns whether or not the ContactPoint is valid.
     *
     * A ContactPoint is considered valid when:
     * - All the properties in `ContactPoint::$REQUIRED_PROPERTIES` are not null
     * - At least one of the following properties is present and valid: `$this->email`,
     * `$this->webpage`, `$this->phone`
     * - All the present DCATEntities contained within ContactPoint pass their individual validation
     *
     * @see ContactPoint::$REQUIRED_PROPERTIES
     * @return DCATValidationResult The validation result of this ContactPoint
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        if ($this->email == null &&
            $this->webpage == null &&
            $this->phone == null) {
            $result->addMessage(
                sprintf(
                    '%s: email, webpage or phone is required',
                    $this->getName()
                )
            );
        }

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    sprintf(
                        '%s: %s is missing', $this->getName(), $property
                    );
                }
                continue;
            }

            if ($this->$property) {
                if (!$this->$property instanceof DCATEntity) {
                    continue;
                }

                $validation = $this->$property->validate();
                /* @var DCATValidationResult $validation */

                foreach ($validation->getMessages() as $message) {
                    $result->addMessage(
                        sprintf('%s: %s', $this->getName(), $message)
                    );
                }
            }
        }

        return $result;
    }

}
