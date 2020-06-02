import React from 'react';
import ReactDOM from 'react-dom';
import { Alert } from 'bootstrap-4-react';
import NavBar from "./components/navbar.js"
import CurrencyForm from "./components/form.js";
import TableExecute from "./components/form.js";
import '../css/app.css';

class App extends React.Component {
    render() {
        return (
            <div>
                <h1>Список курсов валют</h1>
            </div>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));
ReactDOM.render(<NavBar/>, document.getElementById('navbar'));
ReactDOM.render(<CurrencyForm/>, document.getElementById('form'));
ReactDOM.render(<TableExecute/>, document.getElementById('form'));