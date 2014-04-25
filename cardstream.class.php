<?php

	class CardStream {
		/**
		 * CardStream Hosted API Endpoint
		 *
		 * @var string
		 */
		public $form_url = "https://gateway.cardstream.com/hosted/";

		/**
		 * CardStream Direct API Endpoint
		 *
		 * @var string
		 */
		public $direct_url = "https://gateway.cardstream.com/direct/";

		/**
		 * CardStream secret key, defined below is the test account details
		 * please override this when moving from TEST to LIVE
		 *
		 * $api->secret = 'NewSecretStrongerThanThis';
		 *
		 * then
		 *
		 * $api->signRequest($req);
		 *
		 * or
		 *
		 * $api->signRequest($req, 'NewSecretStrongerThanThis');
		 *
		 * @var string
		 */
		public $secret = "";


		public function __construct( $secret = "Circle4Take40Idea" ) {
			$this->secret = $secret;
		}

		/**
		 * makes a request to the Cardstream Direct API
		 *
		 * @param $params
		 *
		 * @return array|bool
		 */
		function makeApiCall( $params ) {
			$header = array(
				'http' => array(
					'method'        => 'POST',
					'ignore_errors' => true
				)
			);
			if ( $params !== null && !empty( $params ) ) {
				// check if signature has been provided if not, make it
				if ( !isset( $params['signature'] ) ) {
					$params['signature'] = $this->signRequest( $params );
				}

				$params = http_build_query( $params, '', '&' );

				$header["http"]['header']  = 'Content-Type: application/x-www-form-urlencoded';
				$header['http']['content'] = $params;

			}

			$context = stream_context_create( $header );
			$fp      = fopen( $this->direct_url, 'rb', false, $context );
			if ( !$fp ) {
				$res = false;
			} else {
				$res = stream_get_contents( $fp );
				parse_str( $res, $res );
			}

			if ( $res === false ) {
				return false;
			}

			return $res;


		}

		/**
		 * @param      $sig_fields
		 * @param null $secret
		 *
		 * @return string
		 */
		function signRequest( $sig_fields, $secret = null ) {

			if ( is_array( $sig_fields ) ) {
				ksort( $sig_fields );
				$sig_fields = http_build_query( $sig_fields, '', '&' ) . ( $secret === null ? $this->secret : $secret );
			} else {
				$sig_fields .= ( $secret === null ? $this->secret : $secret );
			}

			return hash( 'SHA512', $sig_fields );

		}


		function print_input( $key, $value ) {

			$op = '';

			// have to asign to a var untill php version 5.5 is used more
			if ( !is_array( $value ) ) {
				$tvalue = trim( $value );
			}


			if ( is_array( $value ) ) {
				foreach ( $value as $lkey => $lvalue ) {
					$op .= print_input( $key . '[' . $lkey . ']', $lvalue );
				}
				// if the value is blank, dont put in in the form
			} elseif ( empty( $tvalue ) ) {
				return '';
			} elseif ( strtolower( $key ) === 'customeraddress' ) {
				$op = "<textarea name=\"{$key}\" style=\"display:none;\">{$value}</textarea>";
			} else {
				$op = "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\" />\n";
			}

			return $op;
		}

		function form_signature( $fields, $pre_shared_key ) {

			if ( is_array( $fields['merchantData'] ) ) {
				unset( $fields['merchantData'] );
			}

			foreach ( $fields as $key => $value ) {

				// have to asign to a var untill php version 5.5 is used more
				$tvalue = trim( $value );
				if ( empty( $tvalue ) ) {
					unset( $fields[$key] );
				}
			}

			ksort( $fields );

			return hash( "SHA512", http_build_query( $fields ) . $pre_shared_key ) . '|' . implode( ',', array_keys( $fields ) );
		}

		function build_form( $fields, $secret = null ) {


			$pre_shared_key = $secret === null ? $this->secret : $secret;

			$op = "<form action=\"{$this->form_url}\" method=\"post\">";

			foreach ( $fields as $field => $value ) {
				$op .= print_input( $field, $value );
			}

			$op .= '<input type="hidden" name="signature" value="' . signature( $fields, $pre_shared_key ) . '" />\n';
			$op .= '<input type="submit" name="submit" value="Pay Now" /></form>';


			return $op;
		}


	}
