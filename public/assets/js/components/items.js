import React, { Component } from 'react';
import {BootstrapTable, TableHeaderColumn} from 'react-bootstrap-table';
import 'react-bootstrap-table/dist/react-bootstrap-table.min.css';


class Items extends Component {
    render() {
        this.options = {
            defaultSortName: 'date',  // default sort column name
            defaultSortOrder: 'desc'  // default sort order
        };
        return (
            <div>
                <BootstrapTable  ref='table' data={this.props.data} options={ this.options }>
                    <TableHeaderColumn isKey dataField='numCode' dataSort>
                        numCode
                    </TableHeaderColumn>
                    <TableHeaderColumn dataField='charCode' dataSort>
                        charCode
                    </TableHeaderColumn>
                    <TableHeaderColumn dataField='valuteID' dataSort>
                        valuteID
                    </TableHeaderColumn>
                    <TableHeaderColumn dataField='name' dataSort>
                        name
                    </TableHeaderColumn>
                    <TableHeaderColumn dataField='value' dataSort>
                        value
                    </TableHeaderColumn>
                    <TableHeaderColumn dataField='date' dataSort>
                        date
                    </TableHeaderColumn>
                </BootstrapTable>
            </div>
        );
    }
}

export default Items;