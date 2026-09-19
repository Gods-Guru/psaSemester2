class SiteHeader extends HTMLElement {
    connectedCallback() {
        const isInPagesFolder = window.location.pathname.includes('/pages/');
        const basePath = isInPagesFolder ? '../' : './';

        this.innerHTML = `
            <header>
                <nav aria-label="Main navigation">
                    <a href="${basePath}index.html" aria-label="My Next Level home">My Next Level</a>
                    <ul>
                        <li><a href="${basePath}index.html">Home</a></li>
                        <li><a href="${basePath}pages/about.html">About</a></li>
                        <li><a href="${basePath}pages/programs.html">Programmes</a></li>
                        <li><a href="${basePath}pages/gallery.html">Gallery</a></li>
                        <li><a href="${basePath}pages/get-involved.html">Get Involved</a></li>
                        <li><a href="${basePath}pages/contact.html">Contact</a></li>
                        <li><a href="${basePath}pages/donate.html">Donate</a></li>
                    </ul>
                    <button type="button" aria-label="Open mobile menu">Menu</button>
                </nav>
            </header>
        `;
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
                            <li><a href="${basePath}index.html">Home</a></li>
                            <li><a href="${basePath}pages/about.html">About</a></li>
                            <li><a href="${basePath}pages/programs.html">Programmes</a></li>
                            <li><a href="${basePath}pages/gallery.html">Gallery</a></li>
                            <li><a href="${basePath}pages/contact.html">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>Get Involved</h4>
                        <ul>
                            <li><a href="${basePath}pages/donate.html">Donate</a></li>
                            <li><a href="${basePath}pages/volunteer.html">Volunteer</a></li>
                            <li><a href="${basePath}pages/sponsor.html">Sponsor</a></li>
                            <li><a href="${basePath}pages/community-report.html">Tell us about a community</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4>Contact</h4>
                        <ul>
                            <li>Email: [email placeholder]</li>
                            <li>Phone: [phone placeholder]</li>
                            <li>Address: [address placeholder]</li>
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
