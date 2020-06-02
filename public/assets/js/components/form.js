import React, {useReducer, useState} from "react";
import axios from 'axios';
import ReactDOM from "react-dom";
import CurrencyTable from './items.js'
import {DateRangeInput} from "@datepicker-react/styled";
import {ThemeProvider} from "styled-components";

export default function CurrencyForm() {
    const [currencies, setCurrencies] = useState(null);
    const [state, dispatch] = useReducer(reducer, initialState);
    var fetchData = async () => {
        var dateFrom = $('#startDate').val();
        var dateTo = $('#endDate').val();
        const response = await axios.get(
            '/api/v1/currency?from=' + dateFrom + '&to=' + dateTo
        );
        setCurrencies(response.data);
    };
    React.useEffect(() => {
        fetchData();
    }, []);

    return (
        <div className="AppForm">
            <div>
                <ThemeProvider
                    theme={{
                        breakpoints: ["32em", "48em", "64em"],
                        reactDatepicker: {
                            daySize: [25, 30],
                            fontFamily: "system-ui, -apple-system",
                            colors: {
                                accessibility: "#a39a92",
                                selectedDay: "#bfc2c1",
                                selectedDayHover: "#00af3b",
                                primaryColor: "#959489"
                            }
                        }
                    }}
                >
                    <label>Выберите дату:</label>
                    <DateRangeInput
                        onDatesChange={data => dispatch({type: "dateChange", payload: data})}
                        onFocusChange={focusedInput =>
                            dispatch({type: "focusChange", payload: focusedInput})
                        }
                        startDate={state.startDate} // Date or null
                        endDate={state.endDate} // Date or null
                        focusedInput={state.focusedInput} // START_DATE, END_DATE or null
                        displayFormat="dd.MM.yyyy"
                        maxBookingDate={new Date()}
                        required
                    />
                </ThemeProvider>
                <p></p>
                <button className="btn btn-info" onClick={fetchData}>Найти</button>
            </div>
            <p></p>
            <CurrencyTable data={currencies}/>
        </div>
    );
}

const initialState = {
    startDate: null,
    endDate: null,
    focusedInput: null
};

function reducer(state, action) {
    switch (action.type) {
        case "focusChange":
            return {...state, focusedInput: action.payload};
        case "dateChange":
            return action.payload;
        default:
            throw new Error();
    }
}




