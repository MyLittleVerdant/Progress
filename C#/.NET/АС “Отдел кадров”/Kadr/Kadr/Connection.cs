using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Configuration;
using System.Data.SqlClient;
namespace Kadr
{
    public partial class Connection : Form
    {
        public Connection()
        {
            InitializeComponent();
        }

        private void buttonConnect_Click(object sender, EventArgs e)
        {
            var flag =0;
            var connection =System.Configuration.ConfigurationManager.ConnectionStrings["Kadr.Properties.Settings.Human_ResourcesConnectionString"].ConnectionString;
            string[] mass = connection.Split(';');
            string[] DS = mass[0].Split('=');
            DS[1] = textBoxDS.Text;
            mass[0]= string.Join("=", DS);
            connection = string.Join(";", mass);
            SqlConnection cnSql = new SqlConnection(connection);
            try
            {
                cnSql.Open();
            }
            catch(SqlException ex)  //System.Exception exception
            {
                MessageBox.Show(ex.Message, "Ошибка подключения к серверу", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
            }
            

            if (cnSql.State == ConnectionState.Open)
            {
                cnSql.Close();
                var config = ConfigurationManager.OpenExeConfiguration(ConfigurationUserLevel.None);
                var connectionStringsSection = (ConnectionStringsSection)config.GetSection("connectionStrings");
                connectionStringsSection.ConnectionStrings["Kadr.Properties.Settings.Human_ResourcesConnectionString"].ConnectionString = connection;
                config.Save();
                ConfigurationManager.RefreshSection("connectionStrings");
                Hide();
                var SignIn = new SingIn();
                SignIn.ShowDialog();
                Close();
            }
     
          

           



        }
    }
}
