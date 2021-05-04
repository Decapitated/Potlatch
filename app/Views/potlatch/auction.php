<?php if($isOwner && isset($highestBidder['id'])): ?>
    <div class="owner-item">
        <h1>Highest Bidder: <?= $highestBidder['first_name'].' '.$highestBidder['last_name'] ?></h1>
        <h2>Email: <?= $highestBidder['email'] ?></h2>
    </div>
<?php endif; ?>
<section>
    <carousel>
        <?php if(isset($images) && count($images) > 1): ?>
            <button id="left"><</button>
        <?php endif; ?>
        <images>
            <?php if(isset($images)): ?>
                <?php foreach($images as $filename): ?>
                    <?= img('image/item/'.$item['potlatch_id'].'/'.$item['id'].'/'.$filename) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </images>
        <?php if(isset($images) && count($images) > 1): ?>
            <button id="right">></button>
        <?php endif; ?>
    </carousel>
    <?= form_open('auction/bid') ?>
        <h2><?= $item['title'] ?></h2>
        <div>
            <?php if(isset($highestBid['amount'])): ?>
                <p>Current Bid: $<?= $highestBid['amount'] ?></p>
                <?php if($canBid): ?>
                    <input name="bid" type="number" min="<?= $highestBid['amount']+1 ?>" placeholder="Bid starting at: <?= $highestBid['amount']+1 ?>" required/>
                <?php endif; ?>
            <?php else: ?>
                <p>Starting Bid: $1</p>
            <?php endif; ?>
        </div>
        <?php if($canBid): ?>
            <button type="submit">Place Bid</button>
        <?php else: ?>
            <button disabled>
                <?php if($isHighestBidder): ?>
                    Highest Bidder
                <?php else: ?>
                    Bid Disabled
                <?php endif; ?>
            </button>
        <?php endif; ?>
        <input name="item_id" type="number" value="<?= $item['id'] ?>" hidden/>
        <?php if(isset($highestBid['amount'])): ?>
            <input name="highestBid" type="number" value="<?= $highestBid['amount']?>" hidden/>
        <?php endif; ?>
    </form>
</section>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script>
    $('carousel #left').click(function(){
        $('carousel images > img:last-child').prependTo('carousel images');
    });

    $('carousel #right').click(function(){
        $('carousel images > img:first-child').appendTo('carousel images');
    });
</script>

<div>
    <?= form_open('/comment/comment') ?>
        <textarea name="comment"></textarea>
        <input name="item_id" type="number" value="<?= $item['id'] ?>" hidden/>
        <button type="submit">Post</button>
    </form>
    <div id="insert_comments" class="container" >
    </div>
</div>
<script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
<script crossorigin src="https://unpkg.com/react@16/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
<?= script_tag(['src' => 'js/Comments.js', 'type' => 'text/babel']) ?>
<script type="text/babel">
    const comments = <?= json_encode($comments) ?>;
    const csrf_field = <?= $csrf_field ?>;
    const csrf_hash = '<?= $csrf_hash ?>';

    console.log(comments);
    ReactDOM.render(
        <CommentDisplay comments={comments} item_id={<?= $item['id'] ?>} csrf_field={csrf_field} csrf_hash={csrf_hash}/>,
        document.getElementById('insert_comments'));
</script>