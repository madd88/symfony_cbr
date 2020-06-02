import React from 'react';
import {Navbar} from "bootstrap-4-react/lib/components";

class NavBar extends React.Component{
    render() {
        return (
            <nav className="navbar navbar-light bg-light">
                <a className="navbar-brand" href="/">
                    Курсы валют
                </a>
            </nav>
        );
    }
}

export default NavBar;