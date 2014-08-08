<?php  namespace tests\Bookkeeper\Service\Validation;

use Mockery as M;

class AbstractLaravelValidatorTest extends \TestCase {

    protected $validator;

    public function setUp()
    {
        parent::setUp();

        $constructorArgs = [M::mock('\Illuminate\Validation\Factory')->shouldIgnoreMissing()];
        $this->validator = M::mock('\Bookkeeper\Service\Validation\AbstractLaravelValidator', $constructorArgs)->makePartial();
    }

    public function tearDown()
    {
        M::close();
    }

    public function test_returns_empty_message_bag_if_no_errors()
    {
        $errors = $this->validator->errors();
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $errors);
        $this->assertCount(0, $errors);
    }

    public function test_errors_should_return_validation_errors_and_manually_added_keys()
    {
        $validationFactoryMock = $this->getValidationFactoryMock();
        $validator = M::mock('\Bookkeeper\Service\Validation\AbstractLaravelValidator', [$validationFactoryMock])->makePartial();

        // Add an arbitry key to errors
        $initialErrors = $validator->errors()->add('anAddedKey', 'value');

        // Let's set the failure on the validator
        $validator->passes();

        // Lets get the resulting errors
        $postErrors = $validator->errors();

        $this->assertTrue($initialErrors->has('anAddedKey'), 'Initial errors should contain a manually added key');
        $this->assertInstanceOf('Illuminate\Support\MessageBag', $postErrors);
        $this->assertTrue($postErrors->has('initialFailureKey'), 'MessageBag returned from validation does not contain test values');
    }

    protected function getValidationFactoryMock()
    {
        // Set up dummy failure messages from mock validator
        $messageBag = new \Illuminate\Support\MessageBag;
        $messageBag->add('initialFailureKey', 'initialFailureValue');

        // Create the mock validator
        $mockValidator = M::mock(['messages' => $messageBag, 'fails' => true]);

        // Create the mock AbstractLaravelValidator and make sure
        // the dependency returns the mock validator above
        return M::mock('\Illuminate\Validation\Factory', ['make' => $mockValidator])->shouldIgnoreMissing();
    }
}