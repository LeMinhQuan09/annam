(function () {
    /**
     * https://github.com/Modernizr/Modernizr/blob/master/feature-detects/css/flexgap.js
     */

    /*create flex container with row-gap set*/
    let flex = document.createElement('div');
    flex.style.display = 'flex';
    flex.style.flexDirection = 'column';
    flex.style.rowGap = '1px';

    /*create two, elements inside it*/
    flex.appendChild(document.createElement('div'));
    flex.appendChild(document.createElement('div'));

    /*append to the DOM (needed to obtain scrollHeight)*/
    document.body.appendChild(flex);

    /*flex container should be 1px high from the row-gap*/
    let isSupported = flex.scrollHeight === 1;
    flex.parentNode.removeChild(flex);
    if (isSupported) {
        document.documentElement.classList.add('flex-gap-support');
    }
})();
