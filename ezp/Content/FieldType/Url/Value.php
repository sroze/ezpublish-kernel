<?php
/**
 * File containing the Url Value class
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace ezp\Content\FieldType\Url;
use ezp\Content\FieldType\Value as ValueInterface,
    ezp\Persistence\Content\FieldValue as PersistenceFieldValue,
    RuntimeException;

/**
 * Value for Url field type
 */
class Value implements ValueInterface
{
    /**
     * Link content
     *
     * @var string
     */
    public $link;

    /**
     * Text content
     *
     * @var string
     */
    public $text;

    /**
     * Construct a new Value object and initialize it with its $link and optional $text
     *
     * @param string $link
     * @param string $text
     */
    public function __construct( $link, $text = null )
    {
        $this->link = $link;

        if ( $text !== null )
            $this->text = $text;
    }

    /**
     * @see \ezp\Content\FieldType\Value
     */
    public static function build( PersistenceFieldValue $vo )
    {
        throw new RuntimeException( "@TODO: Implement" );
    }

    /**
     * @see \ezp\Content\FieldType\Value
     */
    public static function fromString( $stringValue )
    {
        return new static( $stringValue );
    }

    /**
     * @see \ezp\Content\FieldType\Value
     */
    public function __toString()
    {
        return $this->link;
    }
}
