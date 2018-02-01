<?php

/**
 * @package SimplePortal ElkArte
 *
 * @author SimplePortal Team
 * @copyright 2015-2017 SimplePortal Team
 * @license BSD 3-clause
 * @version 1.0.0 RC1
 */

function template_view_categories()
{
	global $context, $txt;

	echo '
	<div id="sp_view_categories">
		<h3 class="category_header">
			', $context['page_title'], '
		</h3>';

	if (empty($context['categories']))
	{
		echo '
		<div class="sp_content_padding">', $txt['error_sp_no_categories'], '</div>';
	}

	foreach ($context['categories'] as $category)
	{
		echo '
		<div class="sp_content_padding">
			<h4>', $category['link'], '</h4>
			<p>', $category['description'], '</p>
			<span>', sprintf($category['articles'] == 1 ? $txt['sp_has_article'] : $txt['sp_has_articles'], $category['articles']) ,'</span>
		</div>';
	}

	echo '
	</div>';
}

/**
 * View a specific category and all of its articles that it contains
 */
function template_view_category()
{
	global $context, $txt;

	echo '
	<section id="sp_view_category" class="forumposts">
		<h3 class="category_header">
			', $context['page_title'], '
		</h3>';

	if (empty($context['articles']))
	{
		echo '
		<div class="sp_content_padding">', $txt['error_sp_no_articles'], '</div>';
	}

	foreach ($context['articles'] as $article)
	{
		echo '
		<article class="sp_content_padding">
			<div class="sp_article_detail">';

		if (!empty($article['author']['avatar']['image']))
		{
			echo $article['author']['avatar']['image'];
		}

		echo '
				<span class="sp_article_latest">
					', sprintf(!empty($context['using_relative_time']) ? $txt['sp_posted_on_in_by'] : $txt['sp_posted_in_on_by'], $article['category']['link'], $article['date'], $article['author']['link']), '
					<br />
				', sprintf($article['view_count'] == 1 ? $txt['sp_viewed_time'] : $txt['sp_viewed_times'], $article['view_count']) ,', ', sprintf($article['comment_count'] == 1 ? $txt['sp_commented_on_time'] : $txt['sp_commented_on_times'], $article['comment_count']), '
				</span>
				<h4>', $article['link'], '</h4>
			</div>
			<hr />
			<div id="msg_', $article['id'], '" class="inner sp_inner">', $article['preview'], '
				<div class="sp_article_extra">',
					(!empty($article['cut']) ? '<a class="linkbutton" href="' . $article['href'] . '">' . $txt['sp_read_more'] . '</a>' : ''),
					(!empty($article['comment_count']) ? '<a class="linkbutton" href="' . $article['href'] . '#sp_view_comments">' . $txt['sp-articlesComments'] . '</a>' : ''),
					'<a class="linkbutton" href="', $article['href'], '#sp_comment">', $txt['sp_write_comment'], '</a>
				</div>
			</div>
		</article>';
	}

	echo '
	</section>';

	// Pages as well?
	if (!empty($context['page_index']))
		template_pagesection();

	if (!empty($context['using_relative_time']))
	{
		addInlineJavascript('$(\'.sp_article_latest\').addClass(\'relative\');', true);
	}
}
