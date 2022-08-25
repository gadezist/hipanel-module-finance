import { test } from "@hipanel-core/fixtures";
import {expect, Page} from "@playwright/test";
import BillForm from "@hipanel-module-finance/page/bill/BillForm";
import BillHelper from "@hipanel-module-finance/Helper/BillHelper";
import Bill from "@hipanel-module-finance/model/Bill";
import Charge from "@hipanel-module-finance/model/Charge";
import BillView from "@hipanel-module-finance/page/bill/BillView";
import Index from "@hipanel-core/page/Index";

let billId;

const bill: Bill = {
  client: "hipanel_test_user",
  type: "Block Storage HDD L2",
  currency: "$",
  sum: -762.7,
  quantity: 1,
  charges: [
    {
      class: "Client",
      object: "hipanel_test_user1",
      type: "Cash",
      sum: 712.80,
      quantity: 1,
    },
    {
      class: "Client",
      object: "hipanel_test_user2",
      type: "PayPal",
      sum: 49.90,
      quantity: 1,
    }
  ],
};

test("Create and copy bill with charges @hipanel-module-finance @seller", async ({ sellerPage }) => {

  const billHelper = new BillHelper(sellerPage);
  const billForm = new BillForm(sellerPage);
  const indexPage = new Index(sellerPage);

  await billHelper.gotoCreateBill();
  await billForm.fillBill(bill);
  const billId = await billForm.saveBill();

  await indexPage.chooseNumberRowOnTable(1);
  await billHelper.copyBill();
  await billForm.getSavedBillId();

  await billHelper.ensureBillDidntChange(bill, billId);

});

