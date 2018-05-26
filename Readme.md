# Basic HashIds model attribute for Laravel

This package gives you a _very_ basic trait which will return a 6+char [hashid](https://github.com/ivanakimov/hashids.php)
for a $model->id_hash attribute.  It's primarily for our use when doing error reporting to minimise leaking 'real' ids.
Eg, _could_ be useful for GDPR purposes when reporting to a 3rd party service like [Rollbar](https://rollbar.com/).

The package is designed to be zero-config and simple to use - it's to cover our use-case of simply obfuscating the
id's for reporting purposes.  If you need something more configurable or secure - don't use it :-)

## Installation

```
composer require uogsoe/hash-model-id
```

## Usage

In your model (usually your App\User) add the `CanHashUserIds` trait :

```
<?php

namespace App;

use UoGSoE\ModelHashIds\CanHashUserIds;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CanHashUserIds;

    // ...
}
```

Then you can call `$user->id_hash` to get a unique hashid for that model.  So for instance if you are using Rollbar, then you
can set it to use the hash for the person attribute in the error report, eg :

```
// app/Exceptions/Handler.php

    public function report(Exception $exception)
    {
        if (Auth::check() && $this->shouldReport($exception)) {
            $user = Auth::user();
            \Log::error($exception->getMessage(), [
                'person' => ['id' => $user->id_hash]
            ]);
        }
        parent::report($exception);
    }
```

To decode the hash back into a models id, you'll have to do something like (in tinker for instance) :

```
(new UoGSoE\ModelHashIds\Hasher)->decode("the-hash");
```

There's deliberatly no 'easy' way of just doing $model->decode('the-hash') to reduce the chance of leakage.

## Under the hood

The hashids are based on your .env APP_KEY string - so if you decide to change that then you will get different hash's back
from the `->id_hash` calls.  The hashes are a minimum of six characters long as, well, basically six chars is easy to hit
with a mouse when you're copy'n'pasting ;-)

The trait is just a very, very simple wrapper around the original [hashids library for php](https://github.com/ivanakimov/hashids.php) - all credit to the original developers.
