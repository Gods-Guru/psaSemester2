class SiteHeader extends HTMLElement {
    connectedCallback() {
        const isInPagesFolder = window.location.pathname.includes('/pages/');
        const basePath = isInPagesFolder ? '../' : './';

        this.innerHTML = `
            <header>
                <nav aria-label="Main navigation">

                    <a href="${basePath}index.php" aria-label="My Next Level home">
                        My Next Level
                    </a>

                    <button
                        type="button"
                        class="mobile-menu-button"
                        aria-label="Open mobile menu"
                        aria-expanded="false"
                        aria-controls="main-navigation"
                    >
                        Menu
                    </button>

                    <ul id="main-navigation">
                        <li><a href="${basePath}index.php">Home</a></li>
                        <li><a href="${basePath}pages/about.php">About</a></li>
                        <li><a href="${basePath}pages/programs.php">Programmes</a></li>
                        <li><a href="${basePath}pages/gallery.php">Gallery</a></li>
                        <li><a href="${basePath}pages/get-involved.php">Get Involved</a></li>
                        <li><a href="${basePath}pages/contact.php">Contact</a></li>
                        <li><a href="${basePath}pages/donate.php">Donate</a></li>
                    </ul>

                </nav>
            </header>
        `;

        const menuButton = this.querySelector(".mobile-menu-button");
        const navigation = this.querySelector("#main-navigation");

        menuButton.addEventListener("click", () => {
            const isOpen = navigation.classList.toggle("is-open");

            menuButton.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );

            menuButton.setAttribute(
                "aria-label",
                isOpen ? "Close mobile menu" : "Open mobile menu"
            );
        });
    }
}

class SiteFooter extends HTMLElement {
    connectedCallback() {
        const isInPagesFolder = window.location.pathname.includes('/pages/');
        const basePath = isInPagesFolder ? '../' : './';

        this.innerHTML = `
            <footer>
                <div>
                    <div>
                        <h3>My Next Level</h3>
                        <p>A charity organisation focused on building stronger community support and opportunity.</p>
                    </div>

                    <div>
                        <h4>Navigation</h4>
                        <ul>
                            <li><a href="${basePath}index.php">Home</a></li>
                            <li><a href="${basePath}pages/about.php">About</a></li>
                            <li><a href="${basePath}pages/programs.php">Programmes</a></li>
                            <li><a href="${basePath}pages/gallery.php">Gallery</a></li>
                            <li><a href="${basePath}pages/contact.php">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>Get Involved</h4>
                        <ul>
                            <li><a href="${basePath}pages/donate.php">Donate</a></li>
                            <li><a href="${basePath}pages/volunteer.php">Volunteer</a></li>
                            <li><a href="${basePath}pages/sponsor.php">Sponsor</a></li>
                            <li><a href="${basePath}pages/community-report.php">Tell us about a community</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>Contact</h4>
                        <ul>
                            <li>Email: mynextlevel@gmail.org</li>
                            <li>Phone: +(234) 8012345678</li>
                            <li>Address: House 123, Street 456, City</li>
                        </ul>
                    </div>
                </div>

                <p>© 2026 My Next Level. All rights reserved.</p>
            </footer>
        `;
    }
}

customElements.define('site-header', SiteHeader);
customElements.define('site-footer', SiteFooter);
