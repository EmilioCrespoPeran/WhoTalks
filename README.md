## Welcome!

Nowadays there are a lot of companies who hold meetings, but do they take into account people who has any disability? For example, hearing, visual or movility disabilities.

WhoTalks is a open-source project of [Fundación ONCE](https://www.fundaciononce.es/) which is addressed to people who has hearing disabilities in the meetings.

Main goals for this project:
1. Obtain audio and convert the audio to text.
2. Display messages to the assistants in real time.

### Development

This web application implements MVC architecture from scratch without using any PHP framework. We used this [project](https://github.com/googlearchive/webplatform-samples) to obtain speech-to-text and ajax to create an asynchronous chat.

### Requirements

This is a web application, so you need to install Xampp to test it. In order to use asynchronous chat, you have to allow microphones permision.

### Installation

1. Clone this project and store it in htdocs folder of Xampp.
2. Import database scripts in phpMyAdmin.
3. Download composer.phar and install dependences with `php composer.phar install`.
4. Run the app and enjoy!

## Developers

This project was developed by Emilio Crespo and Andrei Erhan at the [Open Summer of Code 2019](https://2019.summerofcode.es/2019.html) held in Madrid, Spain.



