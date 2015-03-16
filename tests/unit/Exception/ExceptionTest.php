<?php


namespace Improv\Exception;

use ContextSpecification\Framework\Concern;
use ContextSpecification\Framework\StaticConcern;

class When_passing_nothing_to_the_constructor extends StaticConcern {

	protected function context( ) {
		$this->becauseWillThrowException( true );
	}

	protected function because( ) {
		new Exception( );
	}

	/**
	 * @test
	 */
	public function should_throw_exception( ) {
		$this->captureException( );
		$this->assertInstanceOf( '\InvalidArgumentException' , $this->exception );
		$this->assertEquals( 'Must supply at least one parameter to the Exception constructor.' , $this->exception->getMessage( ) );
	}
}




class When_first_argument_to_constructor_is_not_a_string extends StaticConcern {

	protected function context( ) {
		$this->becauseWillThrowException( true );
	}

	protected function because( ) {
		new Exception( 24 , 'String as second param' );
	}

	/**
	 * @test
	 */
	public function should_throw_exception( ) {
		$this->captureException( );
		$this->assertInstanceOf( '\InvalidArgumentException' , $this->exception );
		$this->assertEquals( 'First argument must be "string", received "integer".' , $this->exception->getMessage( ) );
	}
}






class When_any_argument_to_constructor_is_an_object extends StaticConcern {

	protected function context( ) {
		$this->becauseWillThrowException( true );
	}


	protected function because( ) {
		new Exception( 'String as first param' , 24 , 'Another string' , new \stdClass() , 'Final string' );
	}

	/**
	 * @test
	 */
	public function should_throw_exception( ) {
		$this->captureException( );
		$this->assertInstanceOf( '\InvalidArgumentException' , $this->exception );
		$this->assertEquals( 'Cannot pass "object" as parameter to Exception constructor.' , $this->exception->getMessage( ) );
	}
}







abstract class BasePositiveScenarioMessageTokenizationConcern extends Concern {

	protected $arg_1 , $arg_2 , $arg_3 , $arg_4;

	protected function createSUT( ) {
		return new Exception( $this->arg_1 , $this->arg_2 , $this->arg_3 , $this->arg_4 );
	}

	protected function because( ) {
		$this->result_actual = $this->sut->getMessage( );
	}

	protected function assertMessageEquality( ) {
		$this->assertEquals( $this->result_expected , $this->result_actual );
	}
}



class When_providing_single_string_argument_and_nothing_else extends BasePositiveScenarioMessageTokenizationConcern {
	protected function context( ) {
		$this->arg_1 = 'This is a plain old message for an Exception';
		$this->result_expected = $this->arg_1;
	}

	/**
	 * @test
	 */
	public function should_have_same_string_as_exceptions_message( ) {
		$this->assertMessageEquality( );
	}
}





class When_providing_format_string_and_one_additional_argument extends BasePositiveScenarioMessageTokenizationConcern {
	protected function context( ) {
		$this->arg_1 = 'This is a format string expecting an integer %d.';
		$this->arg_2 = 24;
		$this->result_expected = sprintf( $this->arg_1 , $this->arg_2 );
	}

	/**
	 * @test
	 */
	public function should_have_correctly_rendered_string_tokenized_with_the_one_parameter( ) {
		$this->assertMessageEquality( );
	}
}



class When_providing_format_string_and_three_additional_arguments extends BasePositiveScenarioMessageTokenizationConcern {
	protected function context( ) {
		$this->arg_1 = 'This is a %s string with %d additional %s.';
		$this->arg_2 = 'format';
		$this->arg_3 = 3;
		$this->arg_4 = 'arguments';

		$this->result_expected = sprintf( $this->arg_1 , $this->arg_2 , $this->arg_3 , $this->arg_4 );
	}

	/**
	 * @test
	 */
	public function should_have_correctly_rendered_string_tokenized_with_the_three_parameters( ) {
		$this->assertMessageEquality( );
	}
}
?> 