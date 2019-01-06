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
?>
<h3>Books</h3>
<a href="/books/add" class="btn btn-success btn-sm">
  <i class="glyphicon glyphicon-plus"></i>
  Add book
</a>

<?php /* [START book_list] */ ?>
<?php if (!empty($books)) { ?>
    <?php foreach($books as $book) { ?>
    <div class="media">
    <a href="/books/<?= $book->getId() ?>">
        <?php /* [START book_image] */ ?>
        <div class="media-left">
        <?php if ($book->getImageUrl()) { ?>
            <img src="<?= $book->getImageUrl() ?>">
        <?php } else { ?>
            <img src="http://placekitten.com/g/128/192">
        <?php } ?>
        </div>
        <?php /* [END book_image] */ ?>
        <div class="media-body">
        <h4><?= $book->getTitle() ?></h4>
        <p><?= $book->getAuthor() ?></p>
        </div>
    </a>
    </div>
    <?php } ?>
<?php } else { ?>
<p>No books found</p>
<?php } ?>
<?php /* [END book_list] */ ?>

<?php if (!empty($next_page_token)) { ?>
<nav>
  <ul class="pager">
    <li><a href="?page_token=<?= $next_page_token ?>">More</a></li>
  </ul>
</nav>
<?php } ?>