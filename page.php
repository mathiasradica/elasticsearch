<?php require 'project.php'; 

$disableSmallerPageNumbers = false;
$disableLargerPageNumbers = false;

?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="text" name="searchTerm">
        <input type="submit">
    </form>
    <span><?php echo $resultSetSize ?> hits:</span>
    <table class="table table-striped">
        <thead>
            <tr>
            <th>score</th>
            <th>name</th>
            <th>sku</th>
            <th>status</th>
            <th>c4_status</th>
            <th>m3_status</th>
            <th>is_returnable</th>
            <th>allow_purchase</th>
            <th>allow_guest_purchase</th>
            <th>allow_back_orders</th>
            <th>manufacturer</th>
            <th>c4_sysid</th>
            <th>replaces</th>
            <th>qty_increments</th>
            <th>ean_number</th>
            <th>updated_at</th>
            <th>dangerous_goods</th>
            <th>competitor_references</th>
            <th>supplier</th>
            <th>visibility</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($response): ?>
            <?php foreach ($response['hits']['hits'] as $hit): ?>
            <tr>
                <td><?php echo $hit['_score']; ?></td>
                <td><?php echo $hit['_source']['name']; ?></td>
                <td><?php echo $hit['_source']['sku']; ?></td>
                <td><?php echo $hit['_source']['status']; ?></td>
                <td><?php echo $hit['_source']['c4_status']; ?></td>
                <td><?php echo $hit['_source']['m3_status']; ?></td>
                <td><?php echo $hit['_source']['is_returnable']; ?></td>
                <td><?php echo $hit['_source']['allow_purchase']; ?></td>
                <td><?php echo $hit['_source']['allow_guest_purchase']; ?></td>
                <td><?php echo $hit['_source']['allow_back_orders']; ?></td>
                <td><?php echo $hit['_source']['manufacturer']; ?></td>
                <td><?php echo $hit['_source']['c4_sysid']; ?></td>
                <td><?php echo $hit['_source']['replaces']; ?></td>
                <td><?php echo $hit['_source']['qty_increments']; ?></td>
                <td><?php echo $hit['_source']['ean_number']; ?></td>
                <td><?php echo $hit['_source']['updated_at']; ?></td>
                <td><?php echo $hit['_source']['dangerous_goods']; ?></td>
                <td><?php echo $hit['_source']['competitor_references']; ?></td>
                <td><?php echo $hit['_source']['supplier']; ?></td>
                <td><?php echo $hit['_source']['visibility']; ?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
    <?php if ($pageCount > 1): ?>
    <nav>
        <ul class="pagination">
            <?php if ($pageIndex > 0): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo ($_SERVER['PHP_SELF'] . '?pageIndex=' . ($pageIndex - 1) . '&searchTerm=' . $searchTerm); ?>">Previous</a>
            </li>
            <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="#">
                    Previous
                </a>
            </li>
            <?php endif;?>

            <?php if ($pageIndex == 0): ?>
            <li class="page-item active">
                <a class="page-link" href="#">
                    1
                </a>
            </li>
            <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo ($_SERVER['PHP_SELF'] . '?pageIndex=0' . '&searchTerm=' . $searchTerm); ?>">1</a>
            </li>
            <?php endif;?>

            <?php for ($i = 1; $i < $pageCount - 1; $i++): ?>
                <?php if ($i < $pageIndex - 5 - max(8 - ($pageCount - $pageIndex), 0)): ?>
                    <?php if ($disableSmallerPageNumbers === false): ?>
                        
                        <?php $disableSmallerPageNumbers = true; ?>
                        
                        <li class="page-item disabled">
                            <a href="#" class="page-link">...</a>
                        </li>

                    <?php endif;?>

                <?php elseif ($i > $pageIndex + 5 && $i > 12): ?>
                    <?php if ($disableLargerPageNumbers === false): ?>

                        <?php $disableLargerPageNumbers = true; ?>

                        <li class="page-item disabled">
                            <a href="#" class="page-link">...</a>
                        </li>

                    <?php endif;?>
                <?php elseif ($i == $pageIndex): ?>

                <li class="page-item active">
                    <a href="#" class="page-link"><?php echo $i + 1; ?></a>
                </li>

                <?php else: ?>

                <li class="page-item">
                    <a class="page-link" href="<?php echo ($_SERVER['PHP_SELF'] . '?pageIndex=' . $i . '&searchTerm=' . $searchTerm); ?>"><?php echo $i + 1; ?></a>
                </li>

                <?php endif;?>
            <?php endfor;?>

            <?php if ($pageIndex == $pageCount - 1): ?>

            <li class="page-item active">
                <a class="page-link" href="#">
                    <?php echo $pageCount ?>
                </a>
            </li>

            <?php else: ?>

            <li class="page-item">
                <a class="page-link" href="<?php echo ($_SERVER['PHP_SELF'] . '?pageIndex=' . ($pageCount - 1) . '&searchTerm=' . $searchTerm); ?>"><?php echo $pageCount ?></a>
            </li>

            <?php endif; ?>

            <?php if ($pageIndex < $pageCount - 1): ?>

            <li class="page-item">
                <a class="page-link" href="<?php echo ($_SERVER['PHP_SELF'] . '?pageIndex=' . ($pageIndex + 1) . '&searchTerm=' . $searchTerm); ?>">Next</a>
            </li>

            <?php else: ?>

            <li class="page-item disabled">
                <a class="page-link" href="#">
                    Next
                </a>
            </li>

            <?php endif;?>
        </ul>
    </nav>
    <?php endif;?>
</body>
</html>