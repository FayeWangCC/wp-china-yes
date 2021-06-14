<?php

namespace LitePress\WP_China_Yes\Template;
?>

<div class="wrap plugin-install-tab-featured">
  <h1 class="wp-heading-inline">添加插件</h1>

  <a href="https://wptest.ibadboy.net/wp-admin/plugin-install.php?tab=upload"
     class="upload-view-toggle page-title-action">
    <span class="upload">上传插件</span>
    <span class="browse">浏览插件</span>
  </a>
  <hr class="wp-header-end">

  <div class="upload-plugin-wrap">
    <div class="upload-plugin">
      <p class="install-help">如果您有.zip格式的插件文件，可以在这里通过上传安装它。</p>
      <form method="post" enctype="multipart/form-data" class="wp-upload-form"
            action="https://wptest.ibadboy.net/wp-admin/update.php?action=upload-plugin">
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="8512c35e98"/>
        <input type="hidden" name="_wp_http_referer" value="/wp-admin/plugin-install.php"/>
        <label class="screen-reader-text" for="pluginzip">插件zip文件</label>
        <input type="file" id="pluginzip" name="pluginzip" accept=".zip"/>
        <input type="submit" name="install-plugin-submit" id="install-plugin-submit" class="button"
               value="现在安装"/></form>
    </div>
  </div>
  <h2 class='screen-reader-text'>筛选插件列表</h2>
  <div class="wp-filter">
    <ul class="filter-links">
      <li class='plugin-install-featured'>
        <a href='/wp-admin/plugin-install.php?tab=featured'
           aria-current="page">插件</a>
      </li>
      <li class='plugin-install-popular'>
        <a href='/wp-admin/admin.php?page=lpstore&subpage=themes'>主题</a>
      </li>
      <li class='plugin-install-recommended'>
        <a href='/wp-admin/plugin-install.php?tab=recommended' class="current">已购</a>
      </li>
      <li class='plugin-install-favorites'>
        <a target="_blank" href='https://litepress.cn/store/vendor-registration'>入驻</a>
      </li>
    </ul>

    <form class="search-form search-plugins" method="get">
      <input type="hidden" name="tab" value="search"/>
      <label class="screen-reader-text" for="typeselector">搜索插件：</label>
      <select name="type" id="typeselector">
        <option value="term" selected='selected'>关键词</option>
        <option value="author">作者</option>
        <option value="tag">标签</option>
      </select>
      <label class="screen-reader-text" for="search-plugins">搜索插件</label>
      <input type="search" name="s" id="search-plugins" value="" class="wp-filter-search" placeholder="搜索插件…"/>
      <input type="submit" id="search-submit" class="button hide-if-js" value="搜索插件"/></form>
  </div>


  <form id="plugin-filter" method="post">


    <div class="wp-list-table widefat plugin-install">
      <h2 class='screen-reader-text'>插件列表</h2>
      <table class="wp-list-table widefat plugins">
        <thead>
        <tr>
          <td class="account_list_thead_first">图标</td>
          <th scope="col" id="name" class="manage-column column-name column-primary">标题</th>
          <th scope="col" id="description" class="manage-column column-description">描述</th>
        </tr>
        </thead>

        <tbody id="the-list">
        <?php foreach ( (array) $apps as $app ): ?>
          <tr class="account_list_tbody_first" data-slug="bbpress" data-plugin="bbpress/bbpress.php">
            <th scope="row" class="check-column">
              <div><img src="<?php echo $app->thumbnail_src ?>" class="" alt=""></div>
            </th>
            <td class="plugin-title column-primary account_list_tbody_second">
              <strong><?php echo $app->name ?></strong>
              <div class="row-actions visible">
              <span class="activate">
                <a href="plugins.php?action=activate&amp;plugin=bbpress%2Fbbpress.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=97b5c01251"
                   id="activate-bbpress" class="edit" aria-label="在站点网络中启用bbPress">安装</a> |
              </span>
                <span class="0">
                  <a class="thickbox" title="授权码"
                     href="#TB_inline?height=800&width=1000&inlineId=donate-<?php echo $app->id; ?>">授权码(<?php echo count( $app->order_api_keys ) ?>个)
                  </a>
                  <div id="donate-<?php echo $app->id; ?>" style="display:none;">
                      <table class="wp-list-table thickbox_table widefat fixed striped table-view-list posts">
                    <thead>
                    <tr>
                        <th scope="col" class="manage-column">
                            <span class="tips">KEY</span>
                        </th>
                        <th scope="col" class="manage-column">
                            <span class="tips">已激活数</span>
                        </th>
                        <th scope="col" class="manage-column">
                            <span class="tips">可激活总数</span>
                        </th>
                    </thead>

                    <tbody id="the-list">
                      <?php foreach ( (array) $app->order_api_keys as $order_api_key ): ?>
                        <tr>
                            <td><?php echo $order_api_key->product_order_api_key ?: ''; ?></td>
                            <td><?php echo $order_api_key->activations_total ?: 0; ?></td>
                            <td><?php echo $order_api_key->activations_purchased_total ?: 0; ?></td>
                        </tr>
                      <?php endforeach; ?>
                        </tbody>
                    </table>
                  </div>
                </span>
              </div>
              <button type="button" class="toggle-row"><span class="screen-reader-text">显示详情</span></button>
            </td>
            <td class="column-description desc">
              <div class="plugin-description"><p><?php echo $app->short_description ?></p></div>
              <div class="inactive second plugin-version-author-uri"><?php echo $app->version ?>版本 | 作者：
                <a href="https://<?php echo $app->author->slug ?? '' ?>"><?php echo $app->author->name ?? '' ?></a> | <a
                        href="https://litepress.cn/wp-admin/network/plugin-install.php?tab=plugin-information&amp;plugin=bbpress&amp;TB_iframe=true&amp;width=600&amp;height=550"
                        class="thickbox open-plugin-details-modal" aria-label="关于bbPress的更多信息"
                        data-title="bbPress">查看详情</a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
          <td class="account_list_thead_first">图标</td>
          <th scope="col" id="name" class="manage-column column-name column-primary">标题</th>
          <th scope="col" id="description" class="manage-column column-description">描述</th>
        </tr>


        </tfoot>

      </table>
    </div>
    <div class="tablenav bottom">

      <br class="clear">
    </div>
  </form>
  <span class="spinner"></span>
</div>