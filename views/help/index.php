<div class="row">
    <div class="col-lg-8">
        <p class="text-muted">Ask questions about using this retail system. Answers come from a curated FAQ (no external AI APIs, no personal data).</p>
        <form method="post" action="<?= url('help.ask') ?>" class="mb-4">
            <?= csrf_field() ?>
            <label for="question" class="form-label">Your question</label>
            <textarea class="form-control mb-2" id="question" name="question" rows="3" required
                      placeholder="How do I place an order?"><?= e($question ?? '') ?></textarea>
            <button type="submit" class="btn btn-primary">Ask assistant</button>
        </form>

        <?php if (!empty($result)): ?>
            <div class="alert alert-<?= $result['matched'] ? 'success' : 'warning' ?>" role="status">
                <strong>Assistant:</strong> <?= e($result['answer']) ?>
                <p class="small mb-0 mt-2">Source: <?= e($result['source']) ?></p>
            </div>
        <?php endif; ?>

        <h2 class="h6 mt-4">Suggested topics</h2>
        <ul class="small">
            <li>Placing orders and checkout</li>
            <li>Order status meanings</li>
            <li>Searching and filtering products</li>
            <li>Admin product management</li>
            <li>AI description assistant</li>
        </ul>
    </div>
</div>
