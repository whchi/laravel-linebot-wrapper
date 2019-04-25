A simple wrapper of `linecorp/line-bot-sdk`

Inspired by [bottener.js](https://github.com/Yoctol/bottender)

# Installation
1. composer install
```bash
composer require whchi/laravel-linebot-wrapper
```
2. publish vendor
```bash
php artisan vendor:publish --provider="Whchi\LaravelLineBotWrapper\LINEBotServiceProvider"
```
3. setup config `config/linebot.php`
```php
return [
    'channelAccessToken' => 'find it in your LINE console'
    'channelSecret' => 'find it in your LINE console'
];
```
4. run migration: create a table named `line_bot_sessions`
5. start use, see sample in [app sample](https://github.com/whchi/laravel-linebot-wrapper/tree/master/samples/app)
> remember to remove VerifyCsrfToken for line route
# Usage
## Initialize
In your webhook entry point
```php
public function __construct()
{
    $context = \App::make('LINEBotContext');
}
...
public function entryPoint(Request $request)
{
    $lineMsg = $request->all();
    $events = collect($lineMsg['events']);
    $events->map(function($event) {
        $this->context->setContext($event);

        ... do whatever you want...
    });
}
```
## Remember bot session
Use event queue is recommended, see [app samples](https://github.com/whchi/laravel-linebot-wrapper/tree/master/samples/app)
```php
// after setContext
event(new SaveLineBotSessionEvent($event));
```
## State handling
Need Redis running in your enviorment
* init state
```php
$this->context->initState([
    'status' => 1,
    'isAuth' => ['departA' => true, 'departB' => false]
    ]);
// must execute after setContext
$this->context->buildState();
```
* set state
```php
$this->context->setState(['status' => 2]);
```
* get state
```php
$this->context->getState('isAuth.departA');
```
* reset state
```php
$this->context->resetState();
```
## Messages handling
see [message samples](https://github.com/whchi/laravel-linebot-wrapper/tree/master/samples/message) for $template
### push API
**Make sure your account have <font color="red">PUSH_API</font> permission**

set userId before use push function
```php
$this->context->setPushTo(string $userId|$groupId|$roomId);
```
* button
```php
$this->context->pushButtonTemplate(string $altText,array $template)
```
* confirm
```php
$this->context->pushConfirmTemplate(string $altText,array $template)
```
* carousel
```php
$this->context->pushCarouselTemplate(string $altText,array $template)
```
* image carousel
```php
$this->context->pushImageCarouselTemplate(string $altText, array $template)
```
* audio
```php
$this->context->pushAudio(array $template)
```
* video
```php
$this->context->pushVideo(array $template)
```
* image
```php
$this->context->pushImage(array $template)
```
* sticker
```php
$this->context->pushSticker(array $template)
```
* location
```php
$this->context->pushLocation(array $template)
```
* text
```php
$this->context->pushText(array $template)
```
* #### multiple messages
Maximum size of `$templateList` is 5, so as reply
```php
$this->context->push(string $altText,array $templateList)
```
* #### multiple users
```php
$this->context->pushMulticast(array $memberIdList, string $altText, array $templateList)
```
* #### flex
Maximum size of carousel flex message is 10, more detail: [official doc](https://developers.line.biz/en/docs/messaging-api/using-flex-messages/)
```php
$this->context->pushFlex(string $altText, array $flexTemplate)
```
* quickReply
see $quickReply example at [message samples](https://github.com/whchi/laravel-linebot-wrapper/tree/master/samples/message)
```php
$this->context->pushButtonTemplate(string $altText, $template + $quickReply);
```
### reply API
Change `pushXXXX` to `replyXXXX` without setting userId, that is.
### Leave API
```php
$this->context->leave();
```
### other usage
* detect event\
more detail see [official doc](https://developers.line.biz/en/reference/messaging-api/#message-event)
```php
$this->context->isXXXXEvent();
// example
$this->context->isMessageEvent();
$this->context->isPostbackEvent();
...
```
* detect message event type
```php
$this->context->isXXXXMessage();
// example
$this->context->isTextMessage();
$this->context->isImageMessage();
...
```
* get message event message
```php
$this->content->getMessagePayload();
```
* get postback data
```php
$this->context->getPostbackPayload();
```
* get user profile\
more detail see [official doc](https://developers.line.biz/en/reference/messaging-api/#get-profile)
```php
$this->context->getUserProfile();
```
* accessable attributes
```php
$this->context->rawEvent;
$this->context->eventType;
$this->context->messageEventType;
```
