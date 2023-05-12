<div class="modal-body">
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="table-responsive cart-table">
            <table class="table text-start">
                <thead>
                <tr>
                    <th scope="col">Фото</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цена</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td>
                            <a href="product/<?= $item['slug'] ?>"><img src="<?= PATH . $item['img'] ?>" alt=""></a>
                        </td>
                        <td><a href="product/<?= $item['slug'] ?>">product/<?= $item['title'] ?></a></td>
                        <td>product/<?= $item['qty'] ?></td>
                        <td>product/<?= $item['price'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h4 class="text-start">empty cart</h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success ripple" data-bs-dismiss="modal">Продолжить покупки</button>

    <?php if (!empty($_SESSION['cart'])): ?>
        <button type="button" class="btn btn-primary">Оформить заказ</button>
        <button type="button" class="btn btn-danger">Очистить корзину</button>
    <?php endif; ?>
</div>