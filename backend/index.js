document.querySelector(".hero");

const carousels = {
    carousel1: {
        desc : 'A place for children to become',
        img : '../images/image1.js'
    },
    carousel2: {
        desc : 'A place where every child is welcome',
        img : '../images/image2.js'
    },
    carousel3: {
        desc : 'A place without discrimination',
        img : '../images/image3.js'
    },
    carousel4: {
        desc : 'Every race tribe and ethnicity',
        img : '../images/image4.js'
    },
};

// There is a problem with the logic here. What I'm trying to do is run a carousel where the background image and text changes every specified number of seconds.

function runcarousel(carousel) {
    for (carousel in carousels) {
        // return carousel.item();
        console.log(carousel);
    }
}