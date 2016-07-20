/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package th.go.dft.rice.report.service.impl;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import th.co.bpg.cde.collection.CJFile;
import th.co.bpg.cde.core.CServiceBase;
import th.co.bpg.cde.data.CDataContext;
import th.co.bpg.cde.report.CReportGenerater;
import th.go.dft.rice.report.model.BaseModel;
import th.go.dft.rice.report.model.BaseReport;
import th.go.dft.rice.report.parameter.BaseParameter;
import th.go.dft.rice.report.service.IReportService;

/**
 *
 * @author KhaengZai
 */
public class ReportService extends CServiceBase implements IReportService {

    private final CDataContext dbcon;

    public ReportService() {
        this.dbcon = this.getDataContext();
    }

    private CReportGenerater newReportGenerater(String reportName, String export) {
        CReportGenerater gen = new CReportGenerater();
        switch (export) {
            case "pdf":
                gen.setExportMode(CReportGenerater.ExportMode.PDF);
                break;
            case "excel":
                gen.setExportMode(CReportGenerater.ExportMode.EXCEL);
                break;
            case "word":
                gen.setExportMode(CReportGenerater.ExportMode.WORD);
                break;
            case "view":
                gen.setExportMode(CReportGenerater.ExportMode.PDF);
                break;
            default:
                gen.setExportMode(CReportGenerater.ExportMode.PDF);
                break;
        }

        gen.setReport(reportName + ".jasper");
        try {
            gen.setReport(new FileInputStream("./reports/" + reportName + ".jasper"));
        } catch (FileNotFoundException ex) {
            Logger.getLogger(ReportService.class.getName()).log(Level.SEVERE, null, ex);
        }
        return gen;
    }

    private CJFile outputFile(String reportName, String export, byte[] out) {
        if (export.equals("pdf")) {
            CJFile file = new CJFile(out, CJFile.CJFileType.PDF, CJFile.CJFileSourceType.STREAM, reportName + ".pdf");
            return file;
        } else if (export.equals("view")) {
            CJFile file = new CJFile(out, CJFile.CJFileType.PDF, CJFile.CJFileSourceType.STREAM);
            return file;
        } else if (export.equals("excel")) {

            CJFile file = new CJFile(out, CJFile.CJFileType.EXCEL, CJFile.CJFileSourceType.STREAM, reportName + ".xls");
            return file;
        } else if (export.equals("word")) {

            CJFile file = new CJFile(out, CJFile.CJFileType.WORD, CJFile.CJFileSourceType.STREAM, reportName + ".doc");

            return file;
        } else {
            CJFile file = new CJFile(out, CJFile.CJFileType.PDF, CJFile.CJFileSourceType.STREAM, reportName + ".pdf");
            return file;
        }
    }

    @Override
    public CJFile export(String reportCode, String auctionCode, String exportType) {
        try {
            Class reportClass = Class.forName("th.go.dft.rice.report.model." + reportCode.toUpperCase() + "_model");
            Class reportParamClass = Class.forName("th.go.dft.rice.report.parameter." + reportCode.toUpperCase() + "_parameter");
            String reportName = reportCode.toUpperCase();

            String printBy = "";

            List<String> param_keys = this.request.getKeys();
            List<String> lparams = new ArrayList<>();
            lparams.add(auctionCode);
            String params_x = " ?1 ";
            for (String k : param_keys) {
                if (!k.equals("reportcode") && !k.equals("export") && !k.equals("auccode")) {
                    if (k.startsWith("p_")) {
                        Object bq = this.request.getValue(String.class, k);
                        if (bq != null) {
                            lparams.add(bq.toString());
                        }
                    }
                }
                if (k.equals("userinfo")) {
                    printBy = (String) this.request.getValue(String.class, k);
                }
            }
            for (int i = 1; i < lparams.size(); i++) {
                params_x = params_x + " , ?" + (i + 1);
            }

            String reportProceduce = "exec sp_" + reportCode.toUpperCase() + params_x;
            List<BaseReport> datas = (List<BaseReport>) this.dbcon.nativeQuery(reportClass, reportProceduce, lparams.toArray());

            Object paramObj = reportParamClass.newInstance();
            BaseParameter bparam = (BaseParameter) paramObj;
            if (datas != null && !datas.isEmpty()) {

                bparam.setAuctionNo(datas.get(0).getAuctionNo());
                bparam.setAuctionCode(datas.get(0).getAuctionCode());
                bparam.setAuctionDate(datas.get(0).getAuctionDate());
                bparam.setREPORT_MAX_COUNT(datas.size());
                bparam.setPrintBy(printBy);
                if (auctionCode.indexOf("-I2") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐเป็นการทั่วไปและเพื่อเข้าสู่อุตสาหกรรม");
                } else if (auctionCode.indexOf("-I") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกรัฐบาลเข้าสู่อุตสาหกรรม");
                } else if (auctionCode.indexOf("-O") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐให้กับภาคเอกชนที่มีคำสั่งซื้อจากต่างประเทศเพื่อการส่งออกต่างประเทศ");
                } else {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐ");
                }
                //การจำหน่ายข้าวสารในสต็อกรัฐบาลเข้าสู่อุตสาหกรรม
                //การจำหน่ายข้าวสารในสต๊อกของรัฐ

            } else {
                bparam.setAuctionNo(auctionCode);
                bparam.setAuctionCode(auctionCode);
                bparam.setAuctionDate("");
                datas = new ArrayList<>();
                bparam.setREPORT_MAX_COUNT(0);
                bparam.setPrintBy(printBy);
                if (auctionCode.indexOf("-I2") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐเป็นการทั่วไปและเพื่อเข้าสู่อุตสาหกรรม");
                } else if (auctionCode.indexOf("-I") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกรัฐบาลเข้าสู่อุตสาหกรรม");
                } else if (auctionCode.indexOf("-O") > -1) {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐให้กับภาคเอกชนที่มีคำสั่งซื้อจากต่างประเทศเพื่อการส่งออกต่างประเทศ");
                } else {
                    bparam.setAuctionName("การจำหน่ายข้าวสารในสต็อกของรัฐ");
                }
                //BaseModel bm=new BaseModel();
                //datas.add(bm);
                //การจำหน่ายข้าวสารในสต๊อกของรัฐ
            }

            bparam.setREPORT_LOCALE(this.locale);
            CReportGenerater gen = this.newReportGenerater(reportName, exportType);
            gen.setParameter(bparam);
            gen.setReportData(datas);
            byte[] out = gen.Export();
            return this.outputFile(reportName, exportType, out);

        } catch (ClassNotFoundException | InstantiationException | IllegalAccessException ex) {
            Logger.getLogger(ReportService.class.getName()).log(Level.SEVERE, null, ex);
        }
        return this.outputFile("RPTERROR", exportType, new byte[]{});
    }

    @Override
    public CJFile checklist(String auctionCode, String bidderQueue, String exportType) {
        try {
            Class reportClass = Class.forName("th.go.dft.rice.report.model.RPTchecklist_model");
            Class reportParamClass = Class.forName("th.go.dft.rice.report.parameter.RPTchecklist_parameter");
            //String reportName = reportCode.toUpperCase().replaceAll("_", "-");
            String reportProceduce = "exec sp_rpt_checklist" + " ?1,?2";
            List<BaseReport> datas = (List<BaseReport>) this.dbcon.nativeQuery(reportClass, reportProceduce, auctionCode, bidderQueue);
            Object paramObj = reportParamClass.newInstance();
            BaseParameter bparam = (BaseParameter) paramObj;
            if (datas != null && !datas.isEmpty()) {

                bparam.setAuctionNo(datas.get(0).getAuctionNo());
                bparam.setAuctionCode(datas.get(0).getAuctionCode());
                bparam.setAuctionDate(datas.get(0).getAuctionDate());
                bparam.setREPORT_MAX_COUNT(datas.size());
            } else {
                bparam.setAuctionNo(auctionCode);
                bparam.setAuctionCode(auctionCode);
                bparam.setAuctionDate("");
                datas = new ArrayList<>();
                bparam.setREPORT_MAX_COUNT(0);
                //BaseModel bm=new BaseModel();
                //datas.add(bm);
            }
            CReportGenerater gen = this.newReportGenerater("RPTchecklist", exportType);
            gen.setParameter(bparam);
            gen.setReportData(datas);
            byte[] out = gen.Export();
            return this.outputFile("RPTchecklist", exportType, out);

        } catch (ClassNotFoundException | InstantiationException | IllegalAccessException ex) {
            Logger.getLogger(ReportService.class.getName()).log(Level.SEVERE, null, ex);
        }
        return this.outputFile("RPTERROR", exportType, new byte[]{});
    }

}
