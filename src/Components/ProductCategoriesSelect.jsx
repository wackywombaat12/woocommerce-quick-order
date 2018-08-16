import React, { Component } from "react";
import Loader from "./Loader.jsx";

class ProductCategoriesSelect extends Component {
  constructor(props) {
    super(props);

    this.handleChange = this.handleChange.bind(this);
    this.getCategoryData = this.getCategoryData.bind(this);

    this.state = {
      category_list: null,
      loading: true
    };
  }

  componentDidMount() {
    this.getCategoryData();
  }

  getCategoryData() {
    jQuery
      .ajax({
        url: "/wp-json/quick-order/v1/categories/",
        type: "GET"
      })
      .then(
        function(result) {
          this.setState({
            category_list: result,
            loading: false
          });
        }.bind(this)
      );
  }

  handleChange(e) {
    this.props.action(e.target.value);
  }

  render() {
    return (
      <div>
        {this.state &&
          this.state.loading &&
          this.state.category_list === null && (
            <tr>
              <td colSpan="6">
                <Loader />
              </td>
            </tr>
          )}
        {this.state &&
          this.state.category_list !== null && (
            <select onChange={this.handleChange}>
              <option value="select">Select a category</option>
              {this.state &&
                this.state.category_list &&
                Object.keys(this.state.category_list).map(index => (
                  <option key={index} value={index}>
                    {this.state.category_list[index]}
                  </option>
                ))}
            </select>
          )}
      </div>
    );
  }
}

export default ProductCategoriesSelect;
