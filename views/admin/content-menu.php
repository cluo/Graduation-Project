<ul class="nav-menu dropdown-menu" style="display: block; margin-left: 20px;  ">
    <li class="dropdown-header">首页管理</li>
    <li class="<? if ($section == '1-1') echo 'active'; ?>"><a href="<?= url(['/admin/content-index-big-pic']) ?>">首页大图</a></li>
    <li class="<? if ($section == '1-2') echo 'active'; ?>"><a href="<?= url(['/admin/content-index-tag']) ?>">首页标签</a></li>
    <li class="<? if ($section == '1-3') echo 'active'; ?>"><a href="<?= url(['/admin/content-index-post']) ?>">首页文章</a></li>
    <li class="<? if ($section == '1-4') echo 'active'; ?>"><a href="<?= url(['/admin/content-index-comment']) ?>">首页评论列表</a></li>
</ul>