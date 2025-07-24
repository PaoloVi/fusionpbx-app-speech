<?php

/**
 * speech_gpt4o class
 *
 * @method null download
 */
if (!class_exists('speech_gpt4o')) {
	class speech_gpt4o implements speech_interface {

		/**
		 * declare private variables
		 */
		private $api_key;
		private $api_url;
		private $path;
		private $filename;
		private $format;
		private $voice;
		private $message;
		private $model;

		/**
		 * called when the object is created
		 */
		public function __construct($settings) {
			//build the setting object and get the recording path
			$this->api_key = $settings->get('speech', 'api_key');
			$this->api_url = $settings->get('speech', 'api_url', 'https://api.openai.com/v1/audio/speech');
		}

		public function set_path(string $audio_path) {
			$this->path = $audio_path;
		}

		public function set_filename(string $audio_filename) {
			$this->filename = $audio_filename;
		}

		public function set_format(string $audio_format) {
			$this->format = $audio_format;
		}

		public function set_voice(string $audio_voice) {
			$this->voice = $audio_voice;
		}

		public function set_language(string $audio_language) {
			//this method is required by the interface but not used by the OpenAI TTS API
		}

		public function set_translate(string $audio_translate) {
			//this method is required by the interface but not used by the OpenAI TTS API
		}

		public function set_message(string $audio_message) {
			$this->message = $audio_message;
		}

		public function is_language_enabled() : bool {
			return false;
		}

		public function is_translate_enabled() : bool {
			return false;
		}

		public function get_voices() : array {
			$voices = array(
				"alloy" => "alloy",
				"ash" => "ash",
				"ballad" => "ballad",
				"coral" => "coral",
				"echo" => "echo",
				"fable" => "fable",
				"nova" => "nova",
				"onyx" => "onyx",
				"sage" => "sage",
				"shimmer" => "shimmer"
			);
			return $voices;
		}

		public function get_languages() : array {
			//OpenAI TTS auto-detects language
			$languages = array();
			return $languages;
		}

		/**
		 * speech - text to speech
		 */
		public function speech() : bool {

			// set the request headers
			$headers = [
				'Authorization: Bearer ' . $this->api_key,
				'Content-Type: application/json'
			];

			// set the http data
			$data['model'] = !empty($this->model) ? $this->model : 'gpt-4o-mini-tts';
			$data['input'] = $this->message;
			$data['voice'] = $this->voice;
			$data['response_format'] = !empty($this->format) ? $this->format : 'wav';

			// initialize curl handle
			$ch = curl_init($this->api_url);

			// set the curl options
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);

			// run the curl request and get the response
			$response = curl_exec($ch);

			// get http code
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			// close the handle
			curl_close($ch);

			// check for errors
			if ($response === false || $http_code != 200) {
				error_log("[speech_openai] CURL Error or HTTP Status != 200. HTTP Code: ".$http_code.". Response: ".$response);
				return false;
			}
			else {
				// save the audio file
				if (!empty($this->path) && !empty($this->filename)) {
					file_put_contents($this->path.'/'.$this->filename, $response);
					return true;
				}
				return false;
			}
		}

		public function set_model(string $model): void {
			if (array_key_exists($model, $this->get_models())) {
				$this->model = $model;
			}
		}

		public function get_models(): array {
			return [
				'gpt-4o-mini-tts' => 'gpt-4o-mini-tts',
				'gpt-4o' => 'gpt-4o',
				'tts-1-hd' => 'tts-1-hd',
				'tts-1' => 'tts-1'
			];
		}
	}
}

?>
