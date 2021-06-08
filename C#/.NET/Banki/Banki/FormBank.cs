using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Banki
{
    public partial class FormBank : Form
    {
        FormMain form;
       
        int select = -1;
        public FormBank(FormMain frm)
        {
            Size Screen = SystemInformation.PrimaryMonitorSize;
            this.Location = new Point(Screen.Width - Width, Screen.Height - Height);
            this.form = frm;
            InitializeComponent();
            buttonAdd.Visible = true;
            buttonEdit.Visible = false;

        }
        public FormBank(DataGridViewRow selectedRow, FormMain frm)
        {
            Size Screen = SystemInformation.PrimaryMonitorSize;
            this.Location = new Point(Screen.Width - Width, Screen.Height - Height);
            InitializeComponent();
            this.form = frm;

            textBoxBIK.Text = selectedRow.Cells[1].Value.ToString();
            textBoxName.Text = selectedRow.Cells[2].Value.ToString();
            textBoxURL.Text = selectedRow.Cells[3].Value.ToString();
            select = selectedRow.Index;
            buttonAdd.Visible = false;
            buttonEdit.Visible = true;

        }


        private void buttonAddBank_Click(object sender, EventArgs e)
        {
            try
            {
                if (string.IsNullOrWhiteSpace(textBoxBIK.Text) || string.IsNullOrWhiteSpace(textBoxName.Text) || string.IsNullOrWhiteSpace(textBoxURL.Text))
                    throw new Banki.Exception("Данные заполнены некорректно!");

                DataRow Row = form.bankiDataSet.Bank.NewRow();
                Row[1] = textBoxBIK.Text;
                Row[2] = textBoxName.Text;
                Row[3] = textBoxURL.Text;
                form.bankiDataSet.Bank.Rows.Add(Row);
                form.bankTableAdapter.Update(form.bankiDataSet.Bank);
                form.bankiDataSet.AcceptChanges();
                form.BankiDataGridView.DataSource = form.bankBindingSource;


                this.Close();
            }
            catch (System.Exception exception)
            {

                MessageBox.Show(exception.Message, "Ошибка", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }
        }



     

        private void buttonEditBank_Click(object sender, EventArgs e)
        {
            DataRowView drw = (DataRowView)form.bankBindingSource.Current;
            BankiDataSet.BankRow row = (BankiDataSet.BankRow)drw.Row;



            row.BIK = textBoxBIK.Text;
            row.Title = textBoxName.Text;
            row.URL = textBoxURL.Text;


            if (select != -1)
            {
                form.bankiDataSet.Bank.Rows[select].ItemArray[1] = row.ItemArray[1];
                form.bankiDataSet.Bank.Rows[select].ItemArray[2] = row.ItemArray[2];

            }
            else
                form.bankiDataSet.Bank.Rows.Add(row);
            form.tableAdapterManager.UpdateAll(form.bankiDataSet);
            form.bankiDataSet.AcceptChanges();

            this.Close();
        }
    }
}
