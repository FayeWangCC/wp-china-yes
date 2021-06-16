<?php

namespace LitePress\WP_China_Yes\Template;

use stdClass;
use function LitePress\WP_China_Yes\Inc\get_template_part;
use function LitePress\WP_China_Yes\Inc\pagination;

$tpl_args = $tpl_args ?? array(
        'projects'           => array(),
        'all_local_projects' => array(),
        'cats'               => new stdClass(),
        'total'              => 0,
        'totalpages'         => 0,
        'paged'              => 0,
    );

?>

<?php add_action( 'wcy_search_form', function () { ?>
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
    <input type="submit" id="search-submit" class="button hide-if-js" value="搜索插件"/>
  </form>
<?php } ); ?>

<?php get_template_part( 'header' ); ?>

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
                <?php foreach ( (array) $tpl_args['cats']->themes as $sub_cat ): ?>
                    <?php echo "<li><a href='?' class='categories-a'>{$sub_cat->terms->name}</a></li>"; ?>
                <?php endforeach; ?>
              </ul>
          </span>
      </li>
    </ul>
  </div>
</section>

<form id="plugin-filter" method="post">
  <section class="woo-ordering">
    <div class="f-sort">
      <a href="javascript:;" class="sort_popularity curr" title="按销量排序" rel="popularity">
        <span class="fs-tit">销量</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="javascript:;" class="sort_rating" title="按好评度排序" rel="rating">
        <span class="fs-tit">好评度</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="javascript:;" class="sort_date" title="按最新内容排序" rel="date">
        <span class="fs-tit">新品</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
      <a href="javascript:;" class="sort_price" title="按价格从低到高排序" rel="price">
        <span class="fs-tit">价格</span>
        <em class="fs-up">
          <span class="dashicons dashicons-arrow-up-alt"></span>
        </em>
      </a>
      <a href="javascript:;" class="sort_price-desc" title="按价格从高到低排序" rel="price-desc">
        <span class="fs-tit">价格</span>
        <em class="fs-down">
          <span class="dashicons dashicons-arrow-down-alt"></span>
        </em>
      </a>
    </div>
    <div class="tablenav top">
      <div class="alignleft actions"></div>
      <h2 class="screen-reader-text">插件列表导航</h2>
        <?php pagination( $tpl_args['total'], $tpl_args['totalpages'], $tpl_args['paged'] ); ?>
    </div>
  </section>

  <div class="wp-list-table widefat plugin-install">
    <h2 class='screen-reader-text'>插件列表</h2>
    <div class="theme-browser content-filterable rendered">
      <div class="themes wp-clearfix">
          <?php foreach ( $tpl_args['projects'] as $project ): ?>

            <div class="theme" tabindex="0" aria-describedby="twentytwentyone-action twentytwentyone-name"
                 data-slug="twentytwentyone">
              <a class="thickbox" href="#TB_inline?&inlineId=donate-<?php echo $project->id ?>">
                <div class="theme-screenshot">
                  <img src="<?php echo $project->thumbnail_src ?>" alt="">
                </div>

                <span class="more-details">
                  详情及预览
                  </span>
              </a>
              <div class="theme-author">
                作者：<?php echo $project->vendor->name ?: '' ?>
              </div>

              <div class="theme-id-container">
                <h3 class="theme-name"><?php echo $project->name ?: '' ?></h3>
                <div class="theme-actions">
                  <a class="button button-primary theme-install" data-name="<?php echo $project->name ?: '' ?>"
                     data-slug="twentytwentyone"
                     href="https://litepress.cn/wp-admin/network/update.php?action=install-theme&amp;theme=twentytwentyone&amp;_wpnonce=89ad09972d"
                     aria-label="安装<?php echo $project->name ?: '' ?>">
                    安装
                  </a>
                  <button class="button preview install-theme-preview">
                    <a class="thickbox" href="#TB_inline?&inlineId=donate-<?php echo $project->id ?>">预览</a>
                  </button>
                </div>
              </div>
              <div id="donate-<?php echo $project->id ?>" style="display:none;">
                <div class="theme-install-overlay wp-full-overlay expanded iframe-ready" style="display:block;">
                  <div class="wp-full-overlay-sidebar">
                    <div class="wp-full-overlay-header">
                      <button class="close-full-overlay" type="button" >
                        <span class="screen-reader-text">关闭</span>
                      </button>
                      <button class="previous-theme disabled" disabled=""><span class="screen-reader-text">上一个主题</span>
                      </button>
                      <button class="next-theme"><span class="screen-reader-text">下一个主题</span></button>
                      <a href="https://litepress.cn/wp-admin/network/update.php?action=install-theme&amp;theme=twentytwentyone&amp;_wpnonce=9a92004445"
                         class="button button-primary theme-install" data-name="<?php echo $project->name ?: '' ?>"
                         data-slug="<?php echo $project->slug ?: '' ?>">
                        安装
                      </a>
                    </div>
                    <div class="wp-full-overlay-sidebar-content">
                      <div class="install-theme-info">
                        <h3 class="theme-name"><?php echo $project->name ?: '' ?></h3>
                        <span class="theme-by">作者：<?php echo $project->vendor->name ?: '' ?></span>
                        <img class="theme-screenshot" src="<?php echo $project->thumbnail_src ?>" alt="">

                        <div class="theme-details">
                          <div class="theme-rating">
                            <div class="star-rating">
                              <span class="screen-reader-text"><?php echo $project->average_rating ?>星（基于<?php echo $project->rating_count ?>个评级）</span>
                                <?php $rating_num_tmp = (float) $project->average_rating; ?>
                                <?php for ( $i = 0; $i < 5; $i ++ ): ?>
                                    <?php if ( 0 < $rating_num_tmp && $rating_num_tmp < 1 ): ?>
                                    <span class="star dashicons dashicons-star-half"></span>
                                    <?php elseif ( $rating_num_tmp >= 1 ): ?>
                                    <span class="star dashicons dashicons-star-filled"></span>
                                    <?php else: ?>
                                    <span class="star dashicons dashicons-star-empty"></span>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <a class="num-ratings"
                               href="https://litepress.cn/themes/<?php echo $project->slug ?>#tab-reviews">
                              （<?php echo $project->rating_count ?>个评级）
                            </a>
                          </div>
                          <div class="theme-version">
                            版本：<?php echo $project->meta->_api_version_required ?>
                          </div>
                          <div class="theme-description">
                              <?php echo $project->meta->{'51_default_editor'} ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="wp-full-overlay-footer">
                      <button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="折叠边栏">
                        <span class="collapse-sidebar-arrow"></span>
                        <span class="collapse-sidebar-label">收起</span>
                      </button>
                    </div>
                  </div>
                  <div class="wp-full-overlay-main">
                    <iframe src="<?php echo $project->meta->preview_url ?>" title="预览"></iframe>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="tablenav bottom">
      <?php pagination( $tpl_args['total'], $tpl_args['totalpages'], $tpl_args['paged'] ); ?>
    <br class="clear">
  </div>
</form>
<div class="theme-browser content-filterable"></div>

<p class="no-themes">未找到主题，请重新搜索。</p>

<?php get_template_part( 'footer' ); ?>
