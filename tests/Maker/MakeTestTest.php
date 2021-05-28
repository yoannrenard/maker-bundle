<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Tests\Maker;

use Symfony\Bundle\MakerBundle\Maker\MakeTest;
use Symfony\Bundle\MakerBundle\Test\MakerTestCase;
use Symfony\Bundle\MakerBundle\Test\MakerTestDetails;
use Symfony\Component\Filesystem\Filesystem;

class MakeTestTest extends MakerTestCase
{
    public function getTestDetails()
    {
        yield 'TestCase with class name (FooBar)' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'FooBar',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/FooBarTest.php', $directory)));
            }),
        ];

        yield 'TestCase with class name and Suffix (FooBarTest)' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'FooBarTest',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/FooBarTest.php', $directory)));
            }),
        ];

        yield 'TestCase with extended class name (Service\Util)' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'Service\Util',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/Service/UtilTest.php', $directory)));
            }),
        ];

        yield 'TestCase with extended class name and suffix (Service\UtilTest)' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'Service\UtilTest',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/Service/UtilTest.php', $directory)));
            }),
        ];

        yield 'TestCase with fully qualified path name (\App\Tests\Service\UtilTest)' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                '\App\Tests\Service\UtilTest',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/Service/UtilTest.php', $directory)));
            }),
        ];

        // Generate production class
        yield 'TestCase with class name (FooBar) 1' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'FooBar',
                // generate production class
                'yes',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/src/FooBar.php', $directory)));
            }),
        ];

        yield 'TestCase with class name and Suffix (FooBarTest) 2' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'FooBarTest',
                // generate production class
                'yes',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/src/FooBar.php', $directory)));
            }),
        ];

        yield 'TestCase with extended class name (Service\Util) 3' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'Service\Util',
                // generate production class
                'yes',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/src/Service/Util.php', $directory)));
            }),
        ];

        yield 'TestCase with extended class name and suffix (Service\UtilTest) 4' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                'Service\UtilTest',
                // generate production class
                'yes',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/src/Service/Util.php', $directory)));
            }),
        ];

        yield 'TestCase with fully qualified path name (\App\Tests\Service\UtilTest) 5' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                '\App\Tests\Service\UtilTest',
                // generate production class
                'yes',
            ])
            ->assert(function (string $output, string $directory) {
                $this->assertStringContainsString('Success', $output);

                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/src/Service/Util.php', $directory)));
            }),
        ];

        // Generate given production class
        yield 'TestCase with fully qualified path name (\App\Unit\Tests\Service\UtilTest) with given production class' => [MakerTestDetails::createTest(
            $this->getMakerInstance(MakeTest::class),
            [
                // type
                'TestCase',
                // class name
                '\App\Tests\Unit\Service\UtilTest',
                // generate production class
                'yes',
                // production FQPN
                '\App\Service\Util',
            ])
            ->assert(function (string $output, string $directory) {
                $fs = new Filesystem();
                $this->assertTrue($fs->exists(sprintf('%s/tests/Unit/Service/UtilTest.php', $directory)));
                $this->assertTrue($fs->exists(sprintf('%s/src/Service/Util.php', $directory)));
            }),
        ];

//        yield 'KernelTestCase' => [MakerTestDetails::createTest(
//            $this->getMakerInstance(MakeTest::class),
//            [
//                // type
//                'KernelTestCase',
//                // functional test class name
//                'FooBar',
//            ])
//            ->setFixtureFilesPath(__DIR__.'/../fixtures/MakeFunctional'),
//        ];
//
//        yield 'WebTestCase' => [MakerTestDetails::createTest(
//            $this->getMakerInstance(MakeTest::class),
//            [
//                // type
//                'WebTestCase',
//                // functional test class name
//                'FooBar',
//            ])
//            ->setFixtureFilesPath(__DIR__.'/../fixtures/MakeFunctional'),
//        ];
//
//        yield 'PantherTestCase' => [MakerTestDetails::createTest(
//            $this->getMakerInstance(MakeTest::class),
//            [
//                // type
//                'PantherTestCase',
//                // functional test class name
//                'FooBar',
//            ])
//            ->addExtraDependencies('panther')
//            ->setFixtureFilesPath(__DIR__.'/../fixtures/MakeFunctional'),
//        ];
    }
}
