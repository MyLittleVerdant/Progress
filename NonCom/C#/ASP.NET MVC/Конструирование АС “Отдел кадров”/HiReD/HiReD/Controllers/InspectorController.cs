using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Data.Entity;
using System.Threading.Tasks;
using System.Net;
using HiReD.Models;
using System.Configuration;
using System.Data.SqlClient;
using System.Data.Entity.Core.EntityClient;
using System.Data.Entity.Validation;
namespace HiReD.Controllers
{
    public class InspectorController : Controller
    {
        private HiReDEntities db = new HiReDEntities();
        // GET: Insector
        public ActionResult InspectorView()
        {
            List<Complete> InterCruits = new List<Complete>();
            var recruits = db.Recruitments.ToList();


            foreach (var post in recruits)
            {
                Complete Entry = new Complete(post);
                if (post.Interview != null)
                    if (post.Interview.PhoneNumber != null)
                        Entry.Info = post.Interview.FIO + " - " + post.Interview.PhoneNumber;
                    else
                        Entry.Info = post.Interview.FIO + " - " + post.Interview.Email;
                else
                    Entry.Info = "";

                InterCruits.Add(Entry);

            }


            ViewBag.Recruits = InterCruits;

            return View();
        }


        [HttpPost]
        public ActionResult GetInterVIEW(string post, string name)
        {
            var men = PopulateView(post, name);
            return PartialView(men);
        }

        private static List<Interview> PopulateView(string post, string name)
        {


            string serverName = "DESKTOP-S13P8DB";
            string databaseName = "HiReD";


            SqlConnectionStringBuilder sqlBuilder = new SqlConnectionStringBuilder();


            sqlBuilder.DataSource = serverName;
            sqlBuilder.InitialCatalog = databaseName;
            sqlBuilder.IntegratedSecurity = true;


            string providerString = sqlBuilder.ToString();

            List<Interview> items = new List<Interview>();



            using (SqlConnection con = new SqlConnection(providerString))
            {

                string query = "  SELECT distinct Interview.FIO FROM Interview,Recruitment WHERE Interview.Post='" + post +
                    "' and Interview.id NOT IN ( SELECT Recruitment.Info FROM Recruitment WHERE  Recruitment.Info IS NOT NULL )";
                using (SqlCommand cmd = new SqlCommand(query))
                {
                    cmd.Connection = con;
                    con.Open();
                    using (SqlDataReader sdr = cmd.ExecuteReader())
                    {
                        while (sdr.Read())
                        {
                            Interview tmp = new Interview();

                            tmp.FIO = sdr["FIO"].ToString();
                            items.Add(tmp);

                        }
                    }
                    con.Close();
                }

                Interview temp = new Interview();
                temp.FIO = name;
                items.Add(temp);

            }

            return items;
        }

        [HttpPost]
        public ActionResult EditRecuest(string data)
        {
            string[] res = data.Split(new char[] { ',' });
            string temp = res[2];
            Interview interviewee = (db.Interviews.Where(a => a.FIO == temp).ToList())[0];
            Recruitment request = db.Recruitments.Find(Int32.Parse(res[0]));
            request.Status = res[1];
            request.Info = interviewee.id;
            request.Interview = interviewee;



            db.Entry(request).State = EntityState.Modified;
            db.SaveChanges();
            return RedirectToAction("Index");
        }

       
    }
}