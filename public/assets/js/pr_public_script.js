/**
 * Manipulating last page posts per different conditional
 *
 * @author M Lab Studio <info@mlab-studio.com>
 * @link https://mlab-studio.com
 * @version 1.0.0
 * @since 1.0.0
 */
'use strict';

/**
 * Redirection on click event
 *
 * @method {clickRedirection} Passing selected parameter and redirect it
 * @version 1.0.0
 * @since 1.0.0
 * @param classParam {Element} Passed parameter for click event
 */
const clickRedirection = classParam => {
    const getServerData = document.querySelector('#pr_hide_end_page').textContent;

    classParam.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = getServerData;
    });
}

/**
 * Implement conditional for the last posts pages
 *
 * @version 1.0.0
 * @since 1.0.0
 */
if (document.body.classList.contains('single-post')) {

    /**
     * @name {getLastPost} Getting the last post button
     * @type {Element}
     */
    const getLastPost = document.querySelector('a._button._next._another_post');

    /**
     * @name {getDisabledLastPost} Getting the last post button on disabled arrow
     * @type {Element}
     */
    const getDisabledLastPost = document.querySelector('span._button._next._disabled');

    /**
     * @name {getDisabledLastPost} Getting the last post button on disabled arrow
     * @type {Element}
     */
    const getSingleLastPost = document.querySelector('a._button._next._another_post span._1');

    // Last post arrow without disabled attr
    if (getLastPost) {
        document.querySelector('a._button._another_post span._1').textContent = 'Next';
        clickRedirection(getLastPost);
    }

    // Last post arrow with disabled attr
    if (getDisabledLastPost) {
        document.querySelector('span._button span._1').textContent = 'Next';
        getDisabledLastPost.classList.remove('_disabled');
        clickRedirection(getDisabledLastPost);
    }

    // Proceed with the single last post
    if(getSingleLastPost) {
        document.querySelector('a._button._next span._1').textContent = 'Next';
        clickRedirection(getSingleLastPost);
    }
}