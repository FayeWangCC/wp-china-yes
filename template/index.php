<?php

namespace LitePress\WP_China_Yes\Template;

?>
<div class="wrap plugin-install-tab-featured">
  <section class="d-flex align-items-center">
    <div>
      <h1 class="wp-heading-inline">添加插件</h1>

      <a href="https://wptest.ibadboy.net/wp-admin/plugin-install.php?tab=upload"
         class="upload-view-toggle page-title-action">
        <span class="upload">上传插件</span>
        <span class="browse">浏览插件</span>
      </a></div>
    <div class="m-left-auto d-flex align-items-center login-content">
        <?php
        global $wp_china_yes;

        $user_info = $wp_china_yes->get_user_info();
        ?>
        <?php if ( ! empty( $user_info->get_token() ) ): ?>
          你已登录为：
          <a class="login-item" target="_blank"
             href="https://litepress.cn/user/<?php echo $user_info->get_user_nicename() ?>">
            <span class="display-name"><?php echo $user_info->get_user_display_name() ?></span>
          </a>

          注销？
        <?php else: ?>
          <a class="thickbox button button-primary" title="登录"
             href="#TB_inline?height=300&width=300&inlineId=login-1">
            登录
          </a>
          <a class="thickbox button " title="注册" href="https://litepress.cn/register">
            注册
          </a>
        <?php endif; ?>
      <div id="login-1" style="display:none;">
        <div class="login">
          <h2>使用你的LitePress.cn账户登录</h2>

          <p>
            <label for="user_login">用户名或电子邮箱地址</label>
            <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="none">
          </p>

          <div class="user-pass-wrap">
            <label for="user_pass">密码</label>
            <div class="wp-pwd">
              <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20">
              <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0"
                      aria-label="显示密码">
                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
              </button>
            </div>
          </div>
          <p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large wp_login_btn"
                   value="登录">
          </p>
        </div>
      </div>
  </section>
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
               value="现在安装"/>
      </form>
    </div>
  </div>
  <h2 class='screen-reader-text'>筛选插件列表</h2>
  <div class="wp-filter">
    <ul class="filter-links">
      <li class='plugin-install-featured'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore' ); ?>' <?php echo ( ! isset( $_GET['subpage'] ) || 'plugins' === $_GET['subpage'] ) ? 'class="current"' : '' ?>
           aria-current="page">插件</a>
      </li>
      <li class='plugin-install-popular'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore&subpage=themes' ); ?>'>主题</a>
      </li>
      <li class='plugin-install-recommended'>
        <a href='<?php echo admin_url( 'admin.php?page=lpstore&subpage=account' ); ?>'>已购</a>
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

  <section class="wcy-filter wp-filter">
    <div class="row theme-boxshadow">
      <ul>
        <li>
          <i>价格：</i>
          <span class="filter-cost">
            <ul class="filter-cost-ul">
              <li class="all">
                <a href="<?php remove_query_arg( array(
                    'min_price',
                    'max_price'
                ) ) ?>" <?php echo ! isset( $_GET['max_price'] ) && ! isset( $_GET['min_price'] ) ? 'class="active"' : '' ?>>全部</a>
              </li>
              <li>
                <a href="<?php echo add_query_arg( array(
                    'max_price' => '0.01'
                ) ) ?>" <?php echo isset( $_GET['max_price'] ) ? 'class="active"' : '' ?>>免费</a>
              </li>
              <li>
                <a href="<?php echo add_query_arg( array(
                    'min_price' => '0.01'
                ) ) ?>" <?php echo isset( $_GET['min_price'] ) ? 'class="active"' : '' ?>>付费</a>
              </li>
            </ul>
          </span>
        </li>
        <li>
          <i>分类：</i>
          <span class="filter-categories">
              <ul class="filter-cost-ul">
                <li class="all"><a href="?" class="categories-a active">全部</a></li>
                <?php foreach ( (array) $cats as $type => $sub_cats ): ?>
                    <?php foreach ( (array) $sub_cats as $sub_cat ): ?>
                        <?php echo "<li><a href='?' class='categories-a {$type}-cat'>{$sub_cat->terms->name}</a></li>"; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
              </ul>
          </span>
        </li>
      </ul>
    </div>
  </section>

    <?php require_once $tpl ?>

  <span class="spinner"></span>
</div>