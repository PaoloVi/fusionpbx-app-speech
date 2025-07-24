# FusionPBX App Speech (Enhanced with GPT-4o Provider)

This is a fork of the official `fusionpbx-app-speech` application, enhanced to include a dedicated provider for OpenAI's advanced Text-to-Speech models.

## Key Features

* Adds a new, clean and modular TTS provider named **`gpt4o`**.
* Uses the high-quality **`gpt-4o-mini-tts`** model by default for superior voice quality and pronunciation.
* Includes a complete and updated list of all available OpenAI TTS voices.
* The new provider is designed to be self-contained and does not modify the original `openai` provider.

---

## Prerequisites

To use the OpenAI TTS functionality, you will need:

1.  An active OpenAI account.
2.  API credits available in your account.
3.  A generated API Key from the OpenAI Platform: **https://platform.openai.com/api-keys**

---

## Setup Instructions

1.  **Install the Application:**
    Clone this repository into your FusionPBX apps directory. If you have an existing `speech` app, you may want to rename or remove it first.
    ```bash
    git clone [https://github.com/PaoloVi/fusionpbx-app-speech.git](https://github.com/PaoloVi/fusionpbx-app-speech.git) /var/www/fusionpbx/app/speech
    ```

2.  **Set Permissions:**
    Run the following command to set the correct ownership for the web server.
    ```bash
    chown -R www-data:www-data /var/www/fusionpbx/app/speech
    ```

3.  **Register the App in FusionPBX:**
    * Log in to your FusionPBX GUI.
    * Navigate to **Advanced -> Upgrade**.
    * Check the boxes for **App Defaults** and **Schema**.
    * Click **Execute**.

4.  **Configure the Engine:**
    * Navigate to **Advanced -> Default Settings**.
    * Select the **Speech** category.
    * Configure the following settings:
        * `api_key`: Paste your secret API Key from OpenAI. Set to **Enabled: True**.
        * `engine`: Enter the value **`gpt4o`**. Set to **Enabled: True**.
        * `enabled`: Set the value to **`True`**. Set to **Enabled: True**.

5.  **Clear Cache:**
    * **Log Out** and **Log Back In** to ensure all settings are loaded correctly.

---

## Usage

You can now use the new `gpt4o` engine in any FusionPBX feature that supports Text-to-Speech, such as IVR Menus or the Recordings application.
