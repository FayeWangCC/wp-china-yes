<?php

namespace LitePress\WP_China_Yes\Template;

use stdClass;
use function LitePress\WP_China_Yes\Inc\get_how_ago;
use function LitePress\WP_China_Yes\Inc\get_template_part;
use function LitePress\WP_China_Yes\Inc\pagination;
use function LitePress\WP_China_Yes\Inc\prepare_installed_num;

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
                <?php foreach ( (array) $tpl_args['cats']->plugins as $sub_cat ): ?>
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
    <div id="the-list">
        <?php foreach ( $tpl_args['projects'] as $project ): ?>
          <div details_url class="plugin-card plugin-card-<?php echo $project->slug; ?>">
            <div class="plugin-card-top">
              <div class="name column-name">
                  <?php
                  $args               = array(
                      'tab'       => 'plugin-information',
                      'plugin'    => $project->slug,
                      'TB_iframe' => true,
                      'width'     => 800,
                      'height'    => 700,
                  );
                  $plugin_details_url = add_query_arg( $args, admin_url( 'plugin-install.php' ) );
                  ?>
                <h3>
                  <a href="<?php echo $plugin_details_url; ?>"
                     class="thickbox open-plugin-details-modal">
                      <?php echo $project->name; ?>
                    <img src="<?php echo $project->thumbnail_src; ?>" class="plugin-icon" alt=""/>
                  </a>
                </h3>
              </div>
              <div class="action-links">
                <ul class="plugin-action-buttons">
                  <li>
                      <?php if ( (float) $project->price > 0 ): ?>
                        <a class="button thickbox buy_plugin_btn"
                           href="#TB_inline?height=220&width=600&inlineId=dialog-<?php echo $project->id ?>">购买</a>
                        <dialog id="dialog-<?php echo $project->id ?>">
                          <section class="protocol">
                            <header class="protocol_header"><h2></h2></header>
                            <article class="protocol_article">
                            </article>
                            <footer>
                              <a class="button button-primary agree_btn thickbox"
                                 href="#TB_inline?height=220&width=600&inlineId=dialog-1-<?php echo $project->id ?>"">同意</a>
                              <a class="button" onclick="tb_remove();">拒绝</a>
                            </footer>
                            <dialog id="dialog-1-<?php echo $project->id ?>">
                              <section class="checkout">
                                <header><h2>结算</h2></header>
                                <article>
                                  <div class="woocommerce-form-coupon-toggle">

                                    <div class="woocommerce-info">
                                      有优惠券？ <a href="#"
                                               class="showcoupon">点这里输入您的代码</a></div>
                                  </div>
                                  <section
                                          class="checkout_coupon woocommerce-form-coupon bg-white theme-boxshadow"
                                          method="post"
                                          style="position: static; zoom: 1;display: none">

                                    <p>如果您有优惠券代码，请在下面应用代码。</p>
                                    <article>
                                      <p class="form-row form-row-first">
                                        <input type="text" name="coupon_code"
                                               class="input-text"
                                               placeholder="优惠券代码"
                                               id="coupon_code" value="">
                                      </p>

                                      <p class="form-row form-row-last">
                                        <button type="submit"
                                                class="button apply_coupon"
                                                name="apply_coupon"
                                                value="使用优惠券">使用优惠券
                                        </button>
                                      </p>
                                    </article>
                                  </section>
                                  <table class="shop_table woocommerce-checkout-review-order-table">
                                    <thead>
                                    <tr>
                                      <th class="product-name">产品</th>
                                      <th class="product-total">小计</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="cart_item">
                                      <td class="product-name">
                                          <?php echo $project->name; ?><strong
                                                class="product-quantity">×&nbsp;1</strong>
                                        <dl class="variation">
                                          <dt class="variation-">供应商:</dt>
                                          <dd class="variation-"><p>
                                                  <?php if ( ! empty( $project->vendor ) ): ?>
                                                    作者：
                                                      <?php
                                                      /**
                                                       * TODO:点击作者名字应该筛选该作者的作品
                                                       */
                                                      ?>
                                                    <a href="https://litepress.cn/store/archives/product-vendors/"><?php echo $project->vendor->name ?></a>
                                                  <?php else: ?>
                                                    作者：未知
                                                  <?php endif; ?>
                                            </p>
                                          </dd>
                                        </dl>
                                      </td>
                                      <td class="product-total">
                                          <span class="woocommerce-Price-amount amount"><bdi><span
                                                      class="woocommerce-Price-currencySymbol">¥</span><b
                                                      class="total_price"><?php echo $project->price ?></b></bdi></span>
                                      </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>

                                    <tr class="cart-subtotal">
                                      <th>小计</th>
                                      <td><span class="woocommerce-Price-amount amount"><bdi><span
                                                    class="woocommerce-Price-currencySymbol">¥</span><b
                                                    class="subtotal_price"><?php echo $project->price ?></b></bdi></span>
                                      </td>
                                    </tr>

                                    <tr class="order-total">
                                      <th>合计</th>
                                      <td><strong><span
                                                  class="woocommerce-Price-amount amount order-total-price"><bdi><span
                                                      class="woocommerce-Price-currencySymbol">¥</span><b></b></bdi></span></strong>
                                      </td>
                                    </tr>

                                    </tfoot>
                                  </table>
                                </article>
                                <footer>
                                  <div id="payment" class="woocommerce-checkout-payment">
                                    <ul class="wc_payment_methods payment_methods methods">
                                      <li class="wc_payment_method payment_method_xh-wechat-payment-wc">
                                        <input id="payment_method_xh-wechat-payment-wc"
                                               type="radio"
                                               class="input-radio"
                                               name="payment_method"
                                               value="xh-wechat-payment-wc"
                                               checked="checked"
                                               data-order_button_text=""
                                               style="display: none;">

                                        <label for="payment_method_xh-wechat-payment-wc">
                                          微信支付 <img
                                                  src="https://litepress.cn/store/wp-content/plugins/xunhupay-wechat-for-wc/images/logo/wechat.png"
                                                  alt="微信支付"> </label>
                                        <div class="payment_box payment_method_xh-wechat-payment-wc">
                                          <p>二维码扫描支付或H5本地支付，信用卡支付</p>
                                        </div>
                                      </li>
                                    </ul>
                                    <div class="form-row place-order">
                                      <noscript>
                                        由于您的浏览器不支持JavaScript，或者它被禁用，在您付款之前请确保您单击的
                                        <em>更新总计</em>按钮，如果您不这样做，您可能会支付更多钱。
                                        <br/>
                                        <button type="submit" class="button alt"
                                                name="woocommerce_checkout_update_totals"
                                                value="更新总数">更新总数
                                        </button>
                                      </noscript>

                                      <div class="woocommerce-terms-and-conditions-wrapper">

                                      </div>

                                      <label for="users_can_register">
                                        <input name="users_can_register"
                                               type="checkbox"
                                               id="users_can_register"
                                               value="1" checked="checked">
                                        购买协议</label>
                                      <a
                                              class="button button-primary buy_btn thickbox"
                                              name="woocommerce_checkout_place_order"
                                              id="place_order"
                                              href="#TB_inline?height=220&width=600&inlineId=dialog-2-<?php echo $project->id ?>"
                                              product_id="<?php echo $project->id ?>"
                                      >支付
                                      </a>
                                    </div>
                                  </div>
                                </footer>
                                <dialog id="dialog-2-<?php echo $project->id ?>">
                                  <section class="wp-pay">
                                    <header><h2>支付</h2></header>
                                    <article>
                                      <p>请扫描二维码前往微信支付</p>
                                      <div class="qrcode"><small class="authentication-message fade show alert-warning">获取中<i
                                                  class="loading"></i></small></div>
                                    </article>
                                  </section>
                                </dialog>
                              </section>
                            </dialog>
                          </section>
                        </dialog>
                      <?php elseif ( key_exists( $project->slug, $tpl_args['all_local_projects'] ) ): ?>
                          <?php if ( version_compare( $project->meta->_api_new_version, $tpl_args['all_local_projects'][ $project->slug ]['Version'] ?? '1000', '>' ) ): ?>
                              <?php
                              $args              = array(
                                  '_wpnonce' => wp_create_nonce( 'upgrade-plugin_' . $project->slug ),
                                  'action'   => 'upgrade-plugin',
                                  'plugin'   => $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?? '',
                              );
                              $plugin_update_url = add_query_arg( $args, admin_url( 'update.php' ) );
                              ?>
                          <a class="update-now button aria-button-if-js"
                             data-plugin="<?php echo $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?>"
                             data-slug="<?php echo $project->slug ?>"
                             href="<?php echo $plugin_update_url ?>"
                             aria-label="更新<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                             data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                             role="button">立即更新</a>
                          <?php elseif ( 'Activated' === $tpl_args['all_local_projects'][ $project->slug ]['Status'] ?? '' ): ?>
                          <button type="button" class="button button-disabled"
                                  disabled="disabled">已启用
                          </button>
                          <?php else: ?>
                              <?php
                              $args              = array(
                                  '_wpnonce' => wp_create_nonce( 'active_' . $project->slug ),
                                  'action'   => 'active',
                                  'plugin'   => $tpl_args['all_local_projects'][ $project->slug ]['Plugin'] ?? '',
                              );
                              $plugin_active_url = add_query_arg( $args, admin_url( 'plugins.php' ) );
                              ?>
                          <a class="button activate-now" data-slug="<?php echo $project->slug; ?>"
                             href="<?php echo $plugin_active_url; ?>" aria-label="启用现在安装<?php echo $project->name; ?>"
                             data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>">启用</a>
                          <?php endif; ?>
                      <?php else: ?>
                          <?php
                          $args               = array(
                              '_wpnonce' => wp_create_nonce( 'install-plugin_' . $project->slug ),
                              'action'   => 'install-plugin',
                              'plugin'   => $project->slug,
                          );
                          $plugin_install_url = add_query_arg( $args, admin_url( 'update.php' ) );
                          ?>
                        <a class="install-now button" data-slug="<?php echo $project->slug; ?>"
                           href="<?php echo $plugin_install_url; ?>"
                           aria-label="现在安装<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>"
                           data-name="<?php echo $project->name; ?> <?php echo $project->meta->_api_new_version ?>">现在安装</a>
                      <?php endif; ?>
                  </li>
                  <li><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">¥</span><?php echo $project->price ?></bdi></span>
                  </li>
                  <li>
                    <a href="<?php echo $plugin_details_url; ?>"
                       class="thickbox open-plugin-details-modal"
                       aria-label="关于<?php echo $project->name; ?>的更多信息"
                       data-title="<?php echo $project->name; ?>">更多详情
                    </a>
                  </li>

                </ul>
              </div>
              <div class="desc column-description">
                <p><?php echo $project->short_description; ?></p>
                <p class="authors">
                  <cite>
                      <?php if ( ! empty( $project->vendor ) ): ?>
                        作者：
                          <?php
                          /**
                           * TODO:点击作者名字应该筛选该作者的作品
                           */
                          ?>
                        <a href="https://litepress.cn/store/archives/product-vendors/"><?php echo $project->vendor->name ?></a>
                      <?php else: ?>
                        作者：未知
                      <?php endif; ?>
                  </cite>
                </p>
              </div>
            </div>
            <div class="plugin-card-bottom">
              <div class="vers column-rating">
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
                <span class="num-ratings"
                      aria-hidden="true">(<?php echo $project->rating_count ?>)</span>
              </div>
              <div class="column-updated">
                <strong>最近更新：</strong>
                  <?php echo get_how_ago( strtotime( $project->date_modified ) ) ?>
              </div>
              <div class="column-downloaded">
                  <?php echo prepare_installed_num( $project->total_sales ) ?>安装
              </div>
              <div class="column-compatibility">
                  <?php if ( empty( $project->meta->_api_version_required ) ): ?>
                    插件兼容性未知
                  <?php elseif ( version_compare( $GLOBALS['wp_version'], $project->meta->_api_version_required, '>' ) ): ?>
                    <span class="compatibility-compatible">该插件<strong>兼容</strong>于您当前使用的WordPress版本</span>
                  <?php else: ?>
                    <span class="compatibility-compatible">该插件<strong>不兼容</strong>于您当前使用的WordPress版本</span>
                  <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
  </div>
  <div class="tablenav bottom">
      <?php pagination( $tpl_args['total'], $tpl_args['totalpages'], $tpl_args['paged'] ); ?>
    <br class="clear">
  </div>
</form>

<?php get_template_part( 'footer' ); ?>

