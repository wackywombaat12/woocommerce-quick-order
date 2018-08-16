import React, { Component } from "react";
import ProductCategoriesSelect from "./ProductCategoriesSelect.jsx";
import OrderTableRow from "./OrderTableRow.jsx";
import Pagination from "./Pagination.jsx";
import Loader from "./Loader.jsx";

class OrderTable extends Component {
  constructor(props) {
    super(props);

    // Bind the this context to the handler function
    this.selectCategory = this.selectCategory.bind(this);
    this.getProductsByCategory = this.getProductsByCategory.bind(this);
    this.nextPage = this.nextPage.bind(this);
    this.previousPage = this.previousPage.bind(this);

    // Set some state
    this.state = {
      category: null,
      products: null,
      page: 1,
      totalPages: null,
      loading: false
    };
  }

  nextPage() {
    this.setState(
      prevState => {
        return {
          page: prevState.page + 1,
          loading: true,
          products: null
        };
      },
      () => {
        this.getProductsByCategory();
      }
    );
  }

  previousPage() {
    this.setState(
      prevState => {
        return {
          page: prevState.page - 1,
          loading: true,
          products: null
        };
      },
      () => {
        this.getProductsByCategory();
      }
    );
  }

  getProductsByCategory() {
    if (this.state.category !== "select") {
      jQuery
        .ajax({
          url:
            "/wp-json/quick-order/v1/products/" +
            this.state.category +
            "/" +
            this.state.page,
          type: "GET"
        })
        .then(
          function(result) {
            console.log(result);
            this.setState({
              products: result.products,
              totalPages: result.totalPages,
              loading: false
            });
          }.bind(this)
        );
    }
  }

  // This method will be sent to the child component
  selectCategory(data) {
    this.setState(
      {
        category: data,
        loading: true,
        products: null
      },
      () => {
        this.getProductsByCategory();
      }
    );
  }

  render() {
    return (
      <div>
        <ProductCategoriesSelect action={this.selectCategory} />
        <table className="shop_table shop_table_responsive">
          <tbody>
            <tr>
              <th>Image</th>
              <th>Product</th>
              <th>Sku</th>
              <th>QTY</th>
              <th>Price</th>
              <th>In Stock?</th>
              <th>Buy</th>
            </tr>
            {this.state &&
              this.state.loading &&
              this.state.category !== "select" && (
                <tr>
                  <td colSpan="6">
                    <Loader />
                  </td>
                </tr>
              )}
            {this.state &&
              this.state.products !== null &&
              this.state.category !== "select" &&
              this.state.products.map(product => (
                <OrderTableRow
                  key={product.id}
                  product={product}
                  loading={this.state.loading}
                />
              ))}
          </tbody>
        </table>
        {this.state &&
          this.state.totalPages &&
          this.state.totalPages &&
          this.state.category !== "select" && (
            <Pagination
              totalPages={this.state.totalPages}
              page={this.state.page}
              next={this.nextPage}
              previous={this.previousPage}
            />
          )}
      </div>
    );
  }
}

export default OrderTable;
