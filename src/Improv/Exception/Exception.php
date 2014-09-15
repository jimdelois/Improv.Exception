<?php
/**
 * Copyright (c) 2014, Jim DeLois
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author     Jim DeLois <%%PHPDOC_AUTHOR_EMAIL%%>
 * @copyright  2014 Jim DeLois
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @version    %%PHPDOC_VERSION%%
 * @link       https://github.com/improvframework/Improv.Exception
 * @filesource
 *
 */

namespace Improv\Exception;

/**
 * The Base Exception Class to be thrown or extended
 *
 * The Exception class provides the ability to supply "sprintf"-style arguments
 * directly to the constructor and know that the message will be correctly
 * formatted.
 *
 * @author     Jim DeLois <%%PHPDOC_AUTHOR_EMAIL%%>
 */
class Exception extends \Exception {

	public function __construct( ) {
		$args = func_get_args( );

		if ( ! isset( $args[ 0 ] ) ) {
			throw new \InvalidArgumentException( 'Must supply at least one parameter to the Exception constructor.' );
		}

		$first = $args[ 0 ];
		if ( ! is_string( $first ) ) {
			throw new \InvalidArgumentException( sprintf( 'First argument must be "string", received "%s".' , gettype( $first ) ) );
		}

		foreach ( $args as $k => $v ) {
			if ( is_object( $v ) ) {
				throw new \InvalidArgumentException( sprintf( 'Cannot pass "object" as parameter to Exception constructor.' ) );
			}
		}


		$message = $first;
		if ( $args ) {
			$message = call_user_func_array( 'sprintf' , $args );
		}

		parent::__construct( $message );
	}
}

?>