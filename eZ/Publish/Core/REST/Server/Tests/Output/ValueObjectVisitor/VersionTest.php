<?php

/**
 * File containing a test class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */
namespace eZ\Publish\Core\REST\Server\Tests\Output\ValueObjectVisitor;

use eZ\Publish\Core\REST\Common\Tests\Output\ValueObjectVisitorBaseTest;
use eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;
use eZ\Publish\Core\Repository\Values;
use eZ\Publish\Core\REST\Server\Values\Version;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;

class VersionTest extends ValueObjectVisitorBaseTest
{
    protected $fieldTypeSerializerMock;

    public function setUp()
    {
        $this->fieldTypeSerializerMock = $this->getMock(
            'eZ\\Publish\\Core\\REST\\Common\\Output\\FieldTypeSerializer',
            array(),
            array(),
            '',
            false
        );
    }

    /**
     * Test the Version visitor.
     *
     * @return string
     */
    public function testVisit()
    {
        $visitor = $this->getVisitor();
        $generator = $this->getGenerator();

        $generator->startDocument(null);

        $version = new Version(
            new Values\Content\Content(
                array(
                    'versionInfo' => new Values\Content\VersionInfo(
                        array(
                            'versionNo' => 5,
                            'contentInfo' => new ContentInfo(
                                array(
                                    'id' => 23,
                                    'contentTypeId' => 42,
                                )
                            ),
                        )
                    ),
                    'internalFields' => array(
                        new Field(
                            array(
                                'id' => 1,
                                'languageCode' => 'eng-US',
                                'fieldDefIdentifier' => 'ezauthor',
                            )
                        ),
                        new Field(
                            array(
                                'id' => 2,
                                'languageCode' => 'eng-US',
                                'fieldDefIdentifier' => 'ezimage',
                            )
                        ),
                    ),
                )
            ),
            $this->getMockForAbstractClass('eZ\\Publish\\API\\Repository\\Values\\ContentType\\ContentType'),
            array()
        );

        $this->fieldTypeSerializerMock->expects($this->exactly(2))
            ->method('serializeFieldValue')
            ->with(
                $this->isInstanceOf('eZ\\Publish\\Core\\REST\\Common\\Output\\Generator'),
                $this->isInstanceOf('eZ\\Publish\\API\\Repository\\Values\\ContentType\\ContentType'),
                $this->isInstanceOf('eZ\\Publish\\API\\Repository\\Values\\Content\\Field')
            );

        $this->getVisitorMock()->expects($this->exactly(2))
            ->method('visitValueObject');

        $this->addRouteExpectation(
            'ezpublish_rest_loadContentInVersion',
            array(
                'contentId' => $version->content->id,
                'versionNumber' => $version->content->versionInfo->versionNo,
            ),
            "/content/objects/{$version->content->id}/versions/{$version->content->versionInfo->versionNo}"
        );

        $visitor->visit(
            $this->getVisitorMock(),
            $generator,
            $version
        );

        $result = $generator->endDocument(null);

        $this->assertNotNull($result);

        return $result;
    }

    /**
     * @param string $result
     *
     * @depends testVisit
     */
    public function testResultContainsVersionChildren($result)
    {
        $this->assertXMLTag(
            array(
                'tag' => 'Version',
                'children' => array(
                    'less_than' => 2,
                    'greater_than' => 0,
                ),
            ),
            $result,
            'Invalid <Version> element.',
            false
        );
    }

    /**
     * @param string $result
     *
     * @depends testVisit
     */
    public function testResultVersionAttributes($result)
    {
        $this->assertXMLTag(
            array(
                'tag' => 'Version',
                'attributes' => array(
                    'media-type' => 'application/vnd.ez.api.Version+xml',
                    'href' => '/content/objects/23/versions/5',
                ),
            ),
            $result,
            'Invalid <Version> attributes.',
            false
        );
    }

    /**
     * @param string $result
     *
     * @depends testVisit
     */
    public function testResultContainsFieldsChildren($result)
    {
        $this->assertXMLTag(
            array(
                'tag' => 'Fields',
                'children' => array(
                    'less_than' => 3,
                    'greater_than' => 1,
                ),
            ),
            $result,
            'Invalid <Fields> element.',
            false
        );
    }

    /**
     * Get the Version visitor.
     *
     * @return \eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor\Version
     */
    protected function internalGetVisitor()
    {
        return new ValueObjectVisitor\Version($this->fieldTypeSerializerMock);
    }
}
