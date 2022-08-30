using HtmlAgilityPack;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Banki
{
    public partial class FormMain : Form
    {
        public FormMain()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            // TODO: данная строка кода позволяет загрузить данные в таблицу "bankiDataSet.Bank". При необходимости она может быть перемещена или удалена.
            this.bankTableAdapter.Fill(this.bankiDataSet.Bank);
            Parsing();
        }


        static string LoadPage(string url)
        {
            var result = "";
            var request = (HttpWebRequest)WebRequest.Create(url);
            var response = (HttpWebResponse)request.GetResponse();

            if (response.StatusCode == HttpStatusCode.OK)
            {
                var receiveStream = response.GetResponseStream();
                if (receiveStream != null)
                {
                    StreamReader readStream;
                    if (response.CharacterSet == null)
                        readStream = new StreamReader(receiveStream);
                    else
                        readStream = new StreamReader(receiveStream, Encoding.GetEncoding(response.CharacterSet));
                    result = readStream.ReadToEnd();
                    readStream.Close();
                }
                response.Close();
            }
            return result;
        }

        void Parsing()
        {
            //загружаем страницу
            var pageContent = LoadPage(@"https://bik-info.ru/name_1.html");
            var document = new HtmlAgilityPack.HtmlDocument();
            document.LoadHtml(pageContent);
            var classValue = "nav nav-list";
            var LIst = document.DocumentNode.SelectNodes(".//*[@class='" + classValue + "']/li") ?? Enumerable.Empty<HtmlNode>();

            //добавление в БД
            foreach (HtmlNode li in LIst)
            {

                DataRow Row = bankiDataSet.Bank.NewRow();
                var html = li.InnerHtml;
                var text = li.InnerText;

                string[] stringSeparators = new string[] { " - " };
                string[] words = text.Split(stringSeparators, StringSplitOptions.None);

                string[] BIK = words[0].Split(' ');

                Regex regex = new Regex(@"\w*.html\w*");
                MatchCollection matche = regex.Matches(html);

                Row[1] = BIK[1];
                Row[2] = words[1];
                Row[3] = "bik-info.ru/" + matche[0].Value;
                if(bankiDataSet.Bank.Select("BIK=" + Row[1]).Length==0)
                    bankiDataSet.Bank.Rows.Add(Row);
            }
            bankTableAdapter.Update(bankiDataSet.Bank);
            bankiDataSet.AcceptChanges();
            BankiDataGridView.DataSource = bankBindingSource;

        }

        //Bank
        private void buttonDeleteBank_Click(object sender, EventArgs e)
        {
            var rowIndex = this.BankiDataGridView.SelectedCells[0].RowIndex;

            BankiDataGridView.Rows.RemoveAt(rowIndex);
            bankiDataSet.Tables["Bank"].Rows[rowIndex].Delete();
            bankTableAdapter.Update(bankiDataSet);

        }

        private void buttonAddBank_Click(object sender, EventArgs e)
        {
            var bank = new FormBank(this);
            bank.ShowDialog();
        }

        private void buttonEditBank_Click(object sender, EventArgs e)
        {


            if (BankiDataGridView.SelectedRows.Count > 0)
            {
                int selectedrowindex = BankiDataGridView.SelectedCells[0].RowIndex;

                DataGridViewRow selectedRow = BankiDataGridView.Rows[selectedrowindex];

                var bank = new FormBank(selectedRow, this);
                bank.ShowDialog();
                this.bankTableAdapter.Fill(this.bankiDataSet.Bank);
            }
        }
    }
}
