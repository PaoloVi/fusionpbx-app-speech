# FusionPBX App Speech (Enhanced with GPT-4o Provider & Recordings Fix)

This is a fork of the official `fusionpbx-app-speech` application. It has been enhanced to include a dedicated provider for OpenAI's advanced Text-to-Speech models and **includes a critical patch to fix a bug in the core Recordings application**, making GUI-based TTS generation functional.

## Key Features

* Adds a new, clean, and modular TTS provider named **`gpt4o`**.
* Uses the high-quality **`gpt-4o-mini-tts`** model by default for superior voice quality and pronunciation.
* Includes a complete and updated list of all available OpenAI TTS voices.
* Provides a patch for the `app-recordings` module to fix silent failures when generating TTS audio from the GUI.
* The new provider is designed to be self-contained and does not modify the original `openai` provider.

---

## Prerequisites

To use the OpenAI TTS functionality, you will need:

* An active OpenAI account with API credits.
* A generated API Key from the OpenAI Platform: **https://platform.openai.com/api-keys**

---

## Setup Instructions

This setup involves two parts: installing this custom speech app and patching the separate `app-recordings`.

1.  **Clone this Repository**
    Clone this repository to a temporary location on your FusionPBX server (e.g., `/usr/src/`).
    ```bash
    cd /usr/src
    git clone [https://github.com/PaoloVi/fusionpbx-app-speech.git](https://github.com/PaoloVi/fusionpbx-app-speech.git)
    ```

2.  **Install the Custom Speech App**
    Copy the application files from the cloned repository to the FusionPBX `speech` app directory.
    ```bash
    cp -r /usr/src/fusionpbx-app-speech/* /var/www/fusionpbx/app/speech/
    ```

3.  **Apply the Recordings App Patch (CRITICAL STEP)**
    This repository contains a patched `recording_edit.php` file. Copy it to the `app-recordings` directory to fix the TTS generation bug.
    ```bash
    cp /usr/src/fusionpbx-app-speech/patches/app/recordings/recording_edit.php /var/www/fusionpbx/app/recordings/
    ```

4.  **Set Permissions**
    Run the following command to set the correct ownership for all web files.
    ```bash
    chown -R www-data:www-data /var/www/fusionpbx
    ```

5.  **Register Changes in FusionPBX**
    * Log in to your FusionPBX GUI.
    * Navigate to **Advanced -> Upgrade**.
    * Check the boxes for **App Defaults** and **Schema**.
    * Click **Execute**.

6.  **Configure the Engine**
    * Navigate to **Advanced -> Default Settings**.
    * Select the **Speech** category.
    * Configure the following settings:
        * `api_key`: Paste your secret API Key from OpenAI. Set to **Enabled: True**.
        * `engine`: Enter the value **`gpt4o`**. Set to **Enabled: True**.
        * `enabled`: Set the value to **`True`**. Set to **Enabled: True**.

7.  **Clear Cache**
    * **Log Out** and **Log Back In** to ensure all settings are loaded correctly.

---

## Usage

You can now use the new `gpt4o` engine in any FusionPBX feature that supports Text-to-Speech, such as IVR Menus or the Recordings application.
