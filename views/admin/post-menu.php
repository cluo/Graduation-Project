<ul class="nav-menu dropdown-menu" style="display: block; margin-left: 20px;  ">
    <li class="dropdown-header">资讯管理</li>
    <li class="<? if ($section == '1-0' ) echo 'active'; ?>"><a href="<?= url(['/admin/post-list', 'category_id' => 0]) ?>">全部文章</a></li>
    <?
    foreach ($category as $id => $name)
    {
    ?>
        <li class="<? if ($section == '1-' . $id ) echo 'active'; ?>"><a href="<?= url(['/admin/post-list', 'category_id' => $id]) ?>"><?= $name ?></a></li>
    <?
    }
    ?>
</ul>