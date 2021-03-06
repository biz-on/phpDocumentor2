<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2018 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Plugin\Scrybe\Converter\RestructuredText\Visitors;

use Mockery as m;
use phpDocumentor\Plugin\Scrybe\Converter\Metadata\TableOfContents;

/**
 * Test class for the Discovery Visitor.
 */
class DiscoverTest extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
    const FILENAME = 'test';

    protected $document = null;

    protected $converter = null;

    protected $table_of_contents = null;

    /**
     * @var Discover
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Discover($this->getDocumentMock(), '');
    }

    protected function getDocumentMock()
    {
        if (!$this->document) {
            $file = m::mock('\phpDocumentor\Fileset\File');
            $file->shouldReceive('getFileName')
                ->andReturn(self::FILENAME);

            $this->document = m::mock('\phpDocumentor\Plugin\Scrybe\Converter\RestructuredText\Document');
            $this->document->shouldDeferMissing();
            $this->document->shouldReceive('getConverter')
                ->andReturn($this->getConverterMock());

            $this->document->shouldReceive('getFile')
                ->andReturn($file);
        }

        return $this->document;
    }

    protected function getConverterMock()
    {
        if (!$this->converter) {
            $this->converter = m::mock('\phpDocumentor\Plugin\Scrybe\Converter\RestructuredText\ToHtml');
            $this->converter->shouldReceive('getTableOfContents')
                ->andReturn($this->getTableOfContents());
        }

        return $this->converter;
    }

    protected function getTableOfContents()
    {
        if (!$this->table_of_contents) {
            $this->table_of_contents = new TableOfContents();
        }

        return $this->table_of_contents;
    }

    public function testRetrieveTableOfContents()
    {
        $this->assertSame(
            $this->getTableOfContents(),
            $this->object->getTableOfContents()
        );
    }

    public function testRetrieveDocument()
    {
        $this->assertSame(
            $this->getDocumentMock(),
            $this->object->getDocument()
        );
    }
}
