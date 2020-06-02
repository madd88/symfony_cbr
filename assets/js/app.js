import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js2');

class App extends React.Component {
    render() {
        return (
            <div>
            <p>Hello</p>
            </div>
    )
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
