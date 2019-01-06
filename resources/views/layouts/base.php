<?php
/**
 * Copyright 2015 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * @var \Swoft\View\Base\View $this
 */
$user = session()->get('user');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bookshelf - PHP on Google Cloud Platform</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  </head>
  <body>
    <div class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <div class="navbar-brand">Bookshelf</div>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="/books">Books</a></li>
        </ul>
        <p class="navbar-text navbar-right">
          <?php /* [START login] */ ?>
          <?php if (!empty($user)) { ?>
            <?php if ($user['picture']) { ?>
              <img src="<?= $user['picture'] ?>" class="img-circle" width="24" alt="Photo" />
          <?php } ?>
            <span>
              <?= $user['name'] ?>&nbsp;
              <a href="/logout">(logout)</a>
            </span>
          <?php } else { ?>
            <a href="/login">Login</a>
          <?php } ?>
          <?php /* [END login] */ ?>
        </p>

      </div>
    </div>
    <div class="container">
        {_CONTENT_}
    </div>
  </body>
</html>